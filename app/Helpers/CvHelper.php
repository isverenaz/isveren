<?php

namespace App\Helpers;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Str;

class CvHelper
{
    public static function prepareCvData($request, $guard,$cv = null)
    {
        $user_id = auth()->guard($guard)->user()->id;
        $title =  $request->title ?? ($cv['title'] ?? '');

        $data = [
            'user_id' => $user_id,
            "title" => $title,
            "slug" => Str::slug($title),
        ];

        if ($cv) {
            $skills = $cv['skills'] ?? '';
            if (!empty($request->skills)) {
                $newSkills = $request->skills;
                $newSkillsArray = explode(',', $newSkills);
                $newSkillsArray = array_map('trim', $newSkillsArray);
                $skillsArray = $skills ? json_decode($skills, true) : [];
                foreach ($newSkillsArray as $skill) {
                    if (!in_array($skill, $skillsArray)) {
                        $skillsArray[] = $skill;
                    }
                }
                $skills = json_encode($skillsArray);
            }

            $language = $cv['language'] ?? '';
            if (!empty($request->language)) {
                $newLanguage = $request->language;
                $languageArray = $language ? json_decode($language, true) : [];
                if (!in_array($newLanguage['name'], array_column($languageArray, 'name'))) {
                    $languageArray[] = $newLanguage;
                }
                $language = json_encode($languageArray);
            }

            $employment = $cv['experience'] ?? '';
            if (!empty($request->employment)) {
                $newEmployment = $request->employment;
                $employmentArray = $employment ? json_decode($employment, true) : [];
                if (!in_array($newEmployment['company'], array_column($employmentArray, 'company'))) {
                    $employmentArray[] = $newEmployment;
                }
                $employment = json_encode($employmentArray);
            }

            $education = $cv['education'] ?? '';
            if (!empty($request->education)) {
                $newEducation = $request->education;
                $educationArray = $education ? json_decode($education, true) : [];
                if (!in_array($newEducation['level'], array_column($educationArray, 'level'))) {
                    $educationArray[] = $newEducation;
                }
                $education = json_encode($educationArray);
            }

            $projects = $cv['projects'] ?? '';
            if (!empty($request->projects)) {
                $newProjects = $request->project;
                $projectsArray = $projects ? json_decode($projects, true) : [];
                if (!in_array($newProjects['name'], array_column($projectsArray, 'name'))) {
                    $projectsArray[] = $newProjects;
                }
                $projects = json_encode($projectsArray);
            }

            $hobby = $cv['hobby'] ?? '';
            if (!empty($request->hobby)) {
                $newHobby = $request->hobby;
                $newHobbyArray = explode(',', $newHobby);
                $newHobbyArray = array_map('trim', $newHobbyArray);
                $hobbyArray = $hobby ? json_decode($hobby, true) : [];
                foreach ($newHobbyArray as $h) {
                    if (!in_array($h, $hobbyArray)) {
                        $hobbyArray[] = $h;
                    }
                }
                $hobby = json_encode($hobbyArray);
            }

            $social = $cv['socials'] ?? '';
            if (!empty($request->social)) {
                $newSocial = $request->social;
                $socialArray = $social ? json_decode($social, true) : [];
                if (!in_array($newSocial['name'], array_column($socialArray, 'name'))) {
                    $socialArray[] = $newSocial;
                }
                $social = json_encode($socialArray);
            }

            if ($request->hasFile('resume')) {
                $resumeName = time() . '.' . $request->resume->extension();
                $resume = $request->resume->move(public_path('uploads/user/resume'), $resumeName);
                $resume = $resume->getFilename();
            } else {
                $resumeName = $cv['resume'] ?? '';
            }

            $motivation = $request->motivation_letter ?? ($cv['motivation_letter'] ?? '');
            $date = DateTime::createFromFormat('d/m/Y', $request->birthday);
            $birthday = $date ? $date->format('Y-m-d') : null;

            $data = array_merge($data, [
                "birthday" => $birthday ?? ($cv['birthday'] ?? ''),
                "gender_status" => $request->gender_status ?? ($cv['gender_status'] ?? 0),
                "married_status" => $request->married_status ?? ($cv['married_status'] ?? 0),
                "is_child" => $request->is_child ?? ($cv['is_child'] ?? 0),
                "country_id" => $request->country_id ?? ($cv['country_id'] ?? 0),
                "city_id" => $request->city_id ?? ($cv['city_id'] ?? 0),
                "permanent_address" => $request->permanent_address ?? ($cv['permanent_address'] ?? 0),
                "actual_address" => $request->actual_address ?? ($cv['actual_address'] ?? 0),
                "phone" => $request->phone ?? ($cv['phone'] ?? 0),
                "email" => $request->email ?? ($cv['email'] ?? 0),
                "note" => $request->note ?? ($cv['note'] ?? 0),
                "category_id" => $request->category_id ?? ($cv['category_id'] ?? 0),
                "parent_category_id" => $request->parent_category_id ?? ($cv['parent_category_id'] ?? 0),
                "working_hour" => $request->working_hour ?? ($cv['working_hour'] ?? 0),
                "min_salary" => $request->min_salary ?? ($cv['min_salary'] ?? 0),
                "max_salary" => $request->max_salary ?? ($cv['max_salary'] ?? 0),
                "desired_address" => $request->desired_address ?? ($cv['desired_address'] ?? 0),
                'skills' => !empty($skills) ? $skills : [],
                'language' => !empty($language) ? $language : [],
                'experience' => !empty($employment) ? $employment : [],
                'education' => !empty($education) ? $education : [],
                'projects' => !empty($projects) ? $projects : [],
                'hobby' => !empty($hobby) ? $hobby : [],
                'socials' => !empty($social) ? $social : [],
                'resume' => $resumeName,
                'motivation_letter' => $motivation,
            ]);
        }

        return $data;
    }
}
