<?php

namespace App\Http\Controllers\Web\Users;

use App\Helpers\CvHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CvRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Cv;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class CvController extends Controller
{

    protected $uses;

    public function __construct()
    {
        $this->user = auth()->guard('web')->user();
    }

    public function list()
    {
        $data = Cv::with(['country','city','category','parentCategory','workingHour'])->where('user_id', $this->user->id)->first();
        $countries = Country::where('status', 1)->orderBy('name->az','ASC')->get();

        $categories = Category::whereNull('parent_id')->where('status', 1)->orderBy('name->az','ASC')->get();
        $workingHours = JobType::where('status', 1)->orderBy('name->az','ASC')->get();
        return view('web.users.cv', compact('data', 'countries', 'categories', 'workingHours'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CvRequest $cvRequest)
    {
        try {
            $guard = 'web';
            $cv = null;
            $cvData = CvHelper::prepareCvData($cvRequest, $guard,$cv);
            $cv  = Cv::create($cvData);
            if (!empty($cv->id)) {
                return ['success' => true, 'message' => 'Cv uğurla əlavə edildi'];
            }else {
                return ['success' => false, 'error' => 'Cv uğurla əlavə edilmedi'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Xəta baş verdi: ' . $e->getMessage()];
        }
    }

    public function update(CvRequest $cvRequest, $id)
    {

        try {
            $cv = Cv::where(['id' => $id, 'user_id' => $this->user->id])->first();

            $guard = 'web';
            $cvData = CvHelper::prepareCvData($cvRequest, $guard,$cv);
            $cv  = Cv::where(['id' => $id, 'user_id' => $this->user->id])->update($cvData);
//        dd($cv);
            if (!empty($cv)) {
                return ['success' => true, 'message' => 'Cv uğurla düzəliş edildi'];
            }else {
                return ['success' => false, 'error' => 'Cv uğurla düzəliş edilmedi'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Xəta baş verdi: ' . $e->getMessage()];
        }
    }

    public function removeSkill(Request $request)
    {
        $skill = $request->input('skill');
        // İstifadəçinin CV məlumatını əldə et
        $cv = Cv::where('user_id', auth()->id())->first();
        if (!$cv) {
            return response()->json(['message' => 'CV not found'], 404);
        }
        // Mövcud skills dəyərlərini əldə et və JSON-dan array-ə çevir
        $skills = json_decode($cv->skills, true);
        if (!is_array($skills)) {
            return response()->json(['message' => 'Invalid skills format'], 400);
        }
        // Gələn skill-i array içərisindən sil
        $updatedSkills = array_values(array_filter($skills, function ($s) use ($skill) {
            return $s !== $skill;
        }));
        $cv->skills = json_encode($updatedSkills);
        $cv->save();
        return response()->json(['message' => 'Skill removed', 'updated_skills' => $updatedSkills]);
    }

    public function removeLanguage(Request $request)
    {
        $languageData = $request->input('language');
        [$name, $currentlyWorked] = explode('-', $languageData);

        $cv = Cv::where('user_id', auth()->id())->first();
        if (!$cv) {
            return response()->json(['message' => 'CV not found'], 404);
        }
        $languages = json_decode($cv->language, true);

        if (!is_array($languages)) {
            return response()->json(['message' => 'Invalid language format'], 400);
        }
        $updatedLanguages = array_values(array_filter($languages, function ($l) use ($name, $currentlyWorked) {
            return !($l['name'] === $name && $l['currentlyWorked'] === $currentlyWorked);
        }));
        $cv->language = json_encode($updatedLanguages);
        $cv->save();

        return response()->json(['message' => 'Language removed', 'updated_language' => $updatedLanguages]);
    }

    public function removeExperience(Request $request)
    {
        $experienceData = $request->input('experience');
        $parts = array_map('trim', explode('-', $experienceData));
        if (count($parts) !== 2) {
            return response()->json(['message' => 'Invalid experience format'], 400);
        }

        [$position, $company] = $parts;

        $cv = Cv::where('user_id', auth()->id())->first();
        if (!$cv) {
            return response()->json(['message' => 'CV not found'], 404);
        }
        $experiences = json_decode($cv->experience, true);
        if (!is_array($experiences)) {
            return response()->json(['message' => 'Invalid experience format'], 400);
        }
        $updated = array_values(array_filter($experiences, function ($e) use ($position, $company) {
            return !(isset($e['position'], $e['company']) && $e['position'] === $position && $e['company'] === $company);
        }));
        $cv->experience = json_encode($updated);
        $cv->save();
        return response()->json(['message' => 'Experience removed', 'updated' => $updated]);
    }


    public function removeEducation(Request $request)
    {
        $educationData = $request->input('education');
        $parts = array_map('trim', explode('-', $educationData));
        if (count($parts) !== 2) {
            return response()->json(['message' => 'Invalid educationData format'], 400);
        }

        [$specialization, $name] = $parts;

        $cv = Cv::where('user_id', auth()->id())->first();
        if (!$cv) {
            return response()->json(['message' => 'CV not found'], 404);
        }
        $educations = json_decode($cv->education, true);
        if (!is_array($educations)) {
            return response()->json(['message' => 'Invalid education format'], 400);
        }
        $updated = array_values(array_filter($educations, function ($e) use ($specialization, $name) {
            return !(isset($e['specialization'], $e['name']) && $e['specialization'] === $specialization && $e['name'] === $name);
        }));
        $cv->education = json_encode($updated);
        $cv->save();
        return response()->json(['message' => 'education removed', 'updated' => $updated]);
    }

    public function removeProject(Request $request)
    {
        $projectName = trim($request->input('project')); // Trim edirik ki, artıq boşluqlar olmasın.

        if (!$projectName) {
            return response()->json(['message' => 'Invalid project name'], 400);
        }

        $cv = Cv::where('user_id', auth()->id())->first();
        if (!$cv) {
            return response()->json(['message' => 'CV not found'], 404);
        }

        $projects = json_decode($cv->projects, true);
        if (!is_array($projects)) {
            return response()->json(['message' => 'Invalid projects format'], 400);
        }

        // Məlumatları süzgəcdən keçiririk, seçilmiş layihəni silirik
        $updatedProjects = array_values(array_filter($projects, function ($project) use ($projectName) {
            return !(isset($project['name']) && $project['name'] === $projectName);
        }));

        $cv->projects = json_encode($updatedProjects);
        $cv->save();

        return response()->json(['message' => 'Project removed', 'updated' => $updatedProjects]);
    }


    public function removeHobby(Request $request)
    {
        $hobby = $request->input('hobby');
        // İstifadəçinin CV məlumatını əldə et
        $cv = Cv::where('user_id', auth()->id())->first();
        if (!$cv) {
            return response()->json(['message' => 'CV not found'], 404);
        }
        // Mövcud hobby dəyərlərini əldə et və JSON-dan array-ə çevir
        $hobbies = json_decode($cv->hobby, true);
        if (!is_array($hobbies)) {
            return response()->json(['message' => 'Invalid education format'], 400);
        }
        // Gələn hobby-i array içərisindən sil
        $updatedHobby = array_values(array_filter($hobbies, function ($h) use ($hobby) {
            return $h !== $hobby;
        }));
        $cv->hobby = json_encode($updatedHobby);
        $cv->save();
        return response()->json(['message' => 'hobby removed', 'updated_hobby' => $updatedHobby]);
    }

    public function removeSocial(Request $request)
    {
        $social = $request->input('social');
        // İstifadəçinin CV məlumatını əldə et
        $cv = Cv::where('user_id', auth()->id())->first();
        if (!$cv) {
            return response()->json(['message' => 'CV not found'], 404);
        }
        // Mövcud socials dəyərlərini əldə et və JSON-dan array-ə çevir
        $socials = json_decode($cv->socials, true);
        if (!is_array($socials)) {
            return response()->json(['message' => 'Invalid education format'], 400);
        }
        // Gələn socials-i array içərisindən sil
        $updatedSocials = array_values(array_filter($socials, function ($s) use ($social) {

            return $s['name'] !== $social;
        }));
        $cv->socials = json_encode($updatedSocials);
        $cv->save();
        return response()->json(['message' => 'social removed', 'updated_social' => $updatedSocials]);
    }

    public function cities(Request $request)
    {
        $cities = City::where('country_id',$request->country_id)->where('status', 1)->orderBy('name->az','ASC')->get();
        return response()->json($cities);
    }
    public function parentCategory(Request $request)
    {
        $parentCategories = Category::whereNotNull('parent_id')->where('parent_id',$request->parent_id)->where('status', 1)->orderBy('name->az','ASC')->get();
        return response()->json($parentCategories);
    }

}
