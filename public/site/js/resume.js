//is_child yes no
document.addEventListener("DOMContentLoaded", function () {
    const marriedStatusSelect = document.querySelector('select[name="married_status"]');
    const childSection = document.querySelector('#is_child').closest('.col-xl-12');

    function toggleChildSection() {
        const selectedValue = marriedStatusSelect.value;
        if (selectedValue === "1") { // Subay seçilibsə
            childSection.style.display = "none";
        } else {
            childSection.style.display = "block"; // Evli və ya Boşanmış seçilibsə
        }
    }

    // İlk yükləndikdə yoxlayırıq
    toggleChildSection();

    // Seçim dəyişəndə işləsin
    marriedStatusSelect.addEventListener("change", toggleChildSection);
});
//start knowledge
document.addEventListener("DOMContentLoaded", function () {
    const yesKnowledge = document.getElementById("yesKnowledge");
    const noKnowledge = document.getElementById("noKnowledge");
    const employmentAdd = document.getElementById("knowledgeAdd");

    function toggleKnowledgeAdd() {
        if (noKnowledge.checked) {
            knowledgeAdd.style.display = "none";
        } else {
            knowledgeAdd.style.display = "block";
        }
    }

    yesKnowledge.addEventListener("change", toggleKnowledgeAdd);
    noKnowledge.addEventListener("change", toggleKnowledgeAdd);

    // Səhifə yüklənəndə yoxla
    toggleKnowledgeAdd();
});
//start knowledge
document.addEventListener("DOMContentLoaded", function () {
    const yesLang = document.getElementById("yesLang");
    const noLang = document.getElementById("noLang");
    const langAdd = document.getElementById("langAdd");

    function toggleLangAdd() {
        if (noLang.checked) {
            langAdd.style.display = "none";
        } else {
            langAdd.style.display = "block";
        }
    }

    yesLang.addEventListener("change", toggleLangAdd);
    noLang.addEventListener("change", toggleLangAdd);

    // Səhifə yüklənəndə yoxla
    toggleLangAdd();
});
//start hobby
document.addEventListener("DOMContentLoaded", function () {
    const yesHobby = document.getElementById("yesHobby");
    const noHobby = document.getElementById("noHobby");
    const hobbyAdd = document.getElementById("hobbyAdd");

    function toggleHobbyAdd() {
        if (noHobby.checked) {
            hobbyAdd.style.display = "none";
        } else {
            hobbyAdd.style.display = "block";
        }
    }

    yesHobby.addEventListener("change", toggleHobbyAdd);
    noHobby.addEventListener("change", toggleHobbyAdd);

    // Səhifə yüklənəndə yoxla
    toggleHobbyAdd();
});
//start social
document.addEventListener("DOMContentLoaded", function () {
    const yesSocial = document.getElementById("yesSocial");
    const noSocial = document.getElementById("noSocial");
    const socialAdd = document.getElementById("socialAdd");

    function toggleSocialAdd() {
        if (noSocial.checked) {
            socialAdd.style.display = "none";
        } else {
            socialAdd.style.display = "block";
        }
    }

    yesSocial.addEventListener("change", toggleSocialAdd);
    noSocial.addEventListener("change", toggleSocialAdd);

    // Səhifə yüklənəndə yoxla
    toggleSocialAdd();
});
//start work
document.addEventListener("DOMContentLoaded", function () {
    const yesEmployment = document.getElementById("yesEmployment");
    const noEmployment = document.getElementById("noEmployment");
    const employmentAdd = document.getElementById("employmentAdd");

    function toggleEmploymentAdd() {
        if (noEmployment.checked) {
            employmentAdd.style.display = "none";
        } else {
            employmentAdd.style.display = "block";
        }
    }

    yesEmployment.addEventListener("change", toggleEmploymentAdd);
    noEmployment.addEventListener("change", toggleEmploymentAdd);

    // Səhifə yüklənəndə yoxla
    toggleEmploymentAdd();
});
document.addEventListener("DOMContentLoaded", function () {
    const workedYes = document.getElementById("yesCurrentlyWorked");
    const workedNo = document.getElementById("noCurrentlyWorked");
    const workedDateField = document.getElementById("workedDateField");
    const workedNoteField = document.getElementById("workedNoteField");

    function toggleWorked() {
        if (workedYes.checked) {
            workedDateField.style.display = "none";
            workedNoteField.style.display = "none";
        } else {
            workedDateField.style.display = "block";
            workedNoteField.style.display = "block";
        }
    }

    workedYes.addEventListener("change", toggleWorked);
    workedNo.addEventListener("change", toggleWorked);

    // Səhifə yüklənəndə yoxla
    toggleWorked();
});
//end work

//start education
document.addEventListener("DOMContentLoaded", function () {
    const yesStudying = document.getElementById("yesStudying");
    const noStudying = document.getElementById("noStudying");
    const educationAdd = document.getElementById("educationAdd");

    function toggleEducationAdd() {
        if (noStudying.checked) {
            educationAdd.style.display = "none";
        } else {
            educationAdd.style.display = "block";
        }
    }

    yesStudying.addEventListener("change", toggleEducationAdd);
    noStudying.addEventListener("change", toggleEducationAdd);

    // Səhifə yüklənəndə yoxla
    toggleEducationAdd();
});
document.addEventListener("DOMContentLoaded", function () {
    const educationYes = document.getElementById("yesCurrentlyStudying");
    const educationNo = document.getElementById("noCurrentlyStudying");
    const graduationDateField = document.getElementById("graduationDateField");

    function toggleGraduationDate() {
        if (educationYes.checked) {
            graduationDateField.style.display = "none";
        } else {
            graduationDateField.style.display = "block";
        }
    }

    educationYes.addEventListener("change", toggleGraduationDate);
    educationNo.addEventListener("change", toggleGraduationDate);

    // Səhifə yüklənəndə yoxla
    toggleGraduationDate();
});
//end education

//start project
document.addEventListener("DOMContentLoaded", function () {
    const yesProject = document.getElementById("yesProject");
    const noProject = document.getElementById("noProject");
    const projectAdd = document.getElementById("projectAdd");

    function toggleProjectAdd() {
        if (noProject.checked) {
            projectAdd.style.display = "none";
        } else {
            projectAdd.style.display = "block";
        }
    }

    yesProject.addEventListener("change", toggleProjectAdd);
    noProject.addEventListener("change", toggleProjectAdd);

    // Səhifə yüklənəndə yoxla
    toggleProjectAdd();
});
document.addEventListener("DOMContentLoaded", function () {
    const projectYes = document.getElementById("yesCurrentlyProject");
    const projectNo = document.getElementById("noCurrentlyProject");
    const projectDateField = document.getElementById("projectDateField");

    // const projectNoteField = document.getElementById("projectNoteField");

    function toggleProject() {
        if (projectYes.checked) {
            projectDateField.style.display = "none";
            // projectNoteField.style.display = "none";
        } else {
            projectDateField.style.display = "block";
            // projectNoteField.style.display = "block";
        }
    }

    projectYes.addEventListener("change", toggleProject);
    projectNo.addEventListener("change", toggleProject);

    // Səhifə yüklənəndə yoxla
    toggleProject();
});
//end project

//start send to backend
//start save
$(document).ready(function () {
    $('#cvTitle').submit(function (e) {
        e.preventDefault();
        let submitButton = $('#submitTitle');
        // Düyməni deaktiv et və "Yoxlanılır..." yaz
        submitButton.prop('disabled', true).text('Yoxlanır...');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showModalMessage('success', response.message);
                    // 2 saniyə sonra səhifəni yenilə
                    setTimeout(function () {
                        location.reload();
                    }, 100);
                    console.log('Test');
                } else {
                    showModalMessage('error', response.errors || response.message);
                    submitButton.prop('disabled', false).text('Yadda saxla');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    showModalMessage('error', xhr.responseJSON.errors);
                } else {
                    showModalMessage('error', 'Xəta baş verdi.');
                }
                submitButton.prop('disabled', false).text('Yadda saxla');
            }
        });
    });
});
$(document).ready(function () {
    $('#cvAbout').submit(function (e) {
        e.preventDefault();
        let submitButton = $('#submitAbout');
        // Düyməni deaktiv et və "Yoxlanılır..." yaz
        submitButton.prop('disabled', true).text('Yoxlanır...');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showModalMessage('success', response.message);
                    // 2 saniyə sonra səhifəni yenilə
                    setTimeout(function () {
                        location.reload();
                    }, 100);
                } else {
                    showModalMessage('error', response.errors || response.message);
                    submitButton.prop('disabled', false).text('Yadda saxla');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    showModalMessage('error', xhr.responseJSON.errors);
                } else {
                    showModalMessage('error', 'Xəta baş verdi.');
                }
                submitButton.prop('disabled', false).text('Yadda saxla');
            }
        });
    });
});
$(document).ready(function () {
    $('#cvOtherAbout').submit(function (e) {
        e.preventDefault();
        let submitButton = $('#buttonOtherAbout');
        // Düyməni deaktiv et və "Yoxlanılır..." yaz
        submitButton.prop('disabled', true).text('Yoxlanır...');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showModalMessage('success', response.message);
                    // 2 saniyə sonra səhifəni yenilə
                    setTimeout(function () {
                        location.reload();
                    }, 100);
                } else {
                    showModalMessage('error', response.errors || response.message);
                    submitButton.prop('disabled', false).text('Yadda saxla');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    showModalMessage('error', xhr.responseJSON.errors);
                } else {
                    showModalMessage('error', 'Xəta baş verdi.');
                }
                submitButton.prop('disabled', false).text('Yadda saxla');
            }
        });
    });
});
$(document).ready(function () {
    $('#cvSkills').submit(function (e) {
        e.preventDefault();
        let submitButton = $('#buttonSkills');
        // Düyməni deaktiv et və "Yoxlanılır..." yaz
        submitButton.prop('disabled', true).text('Yoxlanır...');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showModalMessage('success', response.message);
                    // 2 saniyə sonra səhifəni yenilə
                    setTimeout(function () {
                        location.reload();
                    }, 100);
                } else {
                    showModalMessage('error', response.errors || response.message);
                    submitButton.prop('disabled', false).text('Yadda saxla');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    showModalMessage('error', xhr.responseJSON.errors);
                } else {
                    showModalMessage('error', 'Xəta baş verdi.');
                }
                submitButton.prop('disabled', false).text('Yadda saxla');
            }
        });
    });
});
$(document).ready(function () {
    $('#cvLanguage').submit(function (e) {
        e.preventDefault();
        let submitButton = $('#buttonLanguage');
        // Düyməni deaktiv et və "Yoxlanılır..." yaz
        submitButton.prop('disabled', true).text('Yoxlanır...');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showModalMessage('success', response.message);
                    // 2 saniyə sonra səhifəni yenilə
                    setTimeout(function () {
                        location.reload();
                    }, 100);
                } else {
                    showModalMessage('error', response.errors || response.message);
                    submitButton.prop('disabled', false).text('Yadda saxla');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    showModalMessage('error', xhr.responseJSON.errors);
                } else {
                    showModalMessage('error', 'Xəta baş verdi.');
                }
                submitButton.prop('disabled', false).text('Yadda saxla');
            }
        });
    });
});
$(document).ready(function () {
    $('#cvEmployment').submit(function (e) {
        e.preventDefault();
        let submitButton = $('#buttonEmployment');
        // Düyməni deaktiv et və "Yoxlanılır..." yaz
        submitButton.prop('disabled', true).text('Yoxlanır...');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showModalMessage('success', response.message);
                    // 2 saniyə sonra səhifəni yenilə
                    setTimeout(function () {
                        location.reload();
                    }, 100);
                } else {
                    showModalMessage('error', response.errors || response.message);
                    submitButton.prop('disabled', false).text('Yadda saxla');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    showModalMessage('error', xhr.responseJSON.errors);
                } else {
                    showModalMessage('error', 'Xəta baş verdi.');
                }
                submitButton.prop('disabled', false).text('Yadda saxla');
            }
        });
    });
});
$(document).ready(function () {
    $('#cvEducation').submit(function (e) {
        e.preventDefault();
        let submitButton = $('#buttonEducation');
        // Düyməni deaktiv et və "Yoxlanılır..." yaz
        submitButton.prop('disabled', true).text('Yoxlanır...');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showModalMessage('success', response.message);
                    // 2 saniyə sonra səhifəni yenilə
                    setTimeout(function () {
                        location.reload();
                    }, 100);
                } else {
                    showModalMessage('error', response.errors || response.message);
                    submitButton.prop('disabled', false).text('Yadda saxla');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    showModalMessage('error', xhr.responseJSON.errors);
                } else {
                    showModalMessage('error', 'Xəta baş verdi.');
                }
                submitButton.prop('disabled', false).text('Yadda saxla');
            }
        });
    });
});
$(document).ready(function () {
    $('#cvProject').submit(function (e) {
        e.preventDefault();
        let submitButton = $('#buttonProject');
        // Düyməni deaktiv et və "Yoxlanılır..." yaz
        submitButton.prop('disabled', true).text('Yoxlanır...');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showModalMessage('success', response.message);
                    // 2 saniyə sonra səhifəni yenilə
                    setTimeout(function () {
                        location.reload();
                    }, 100);
                } else {
                    showModalMessage('error', response.errors || response.message);
                    submitButton.prop('disabled', false).text('Yadda saxla');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    showModalMessage('error', xhr.responseJSON.errors);
                } else {
                    showModalMessage('error', 'Xəta baş verdi.');
                }
                submitButton.prop('disabled', false).text('Yadda saxla');
            }
        });
    });
});
$(document).ready(function () {
    $('#cvHobby').submit(function (e) {
        e.preventDefault();
        let submitButton = $('#buttonHobby');
        // Düyməni deaktiv et və "Yoxlanılır..." yaz
        submitButton.prop('disabled', true).text('Yoxlanır...');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showModalMessage('success', response.message);
                    // 2 saniyə sonra səhifəni yenilə
                    setTimeout(function () {
                        location.reload();
                    }, 100);
                } else {
                    showModalMessage('error', response.errors || response.message);
                    submitButton.prop('disabled', false).text('Yadda saxla');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    showModalMessage('error', xhr.responseJSON.errors);
                } else {
                    showModalMessage('error', 'Xəta baş verdi.');
                }
                submitButton.prop('disabled', false).text('Yadda saxla');
            }
        });
    });
});
$(document).ready(function () {
    $('#cvSocial').submit(function (e) {
        e.preventDefault();
        let submitButton = $('#buttonSocial');
        // Düyməni deaktiv et və "Yoxlanılır..." yaz
        submitButton.prop('disabled', true).text('Yoxlanır...');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showModalMessage('success', response.message);
                    // 2 saniyə sonra səhifəni yenilə
                    setTimeout(function () {
                        location.reload();
                    }, 100);
                } else {
                    showModalMessage('error', response.errors || response.message);
                    submitButton.prop('disabled', false).text('Yadda saxla');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    showModalMessage('error', xhr.responseJSON.errors);
                } else {
                    showModalMessage('error', 'Xəta baş verdi.');
                }
                submitButton.prop('disabled', false).text('Yadda saxla');
            }
        });
    });
});
$(document).ready(function () {
    $('#resumeButton').on('change', function () {
        let formData = new FormData($('#cvResume')[0]);
        let submitButton = $('.resume-button'); // Alternativ olaraq submit düyməsini tapaq

        // Düyməni deaktiv et və mətnini dəyiş
        submitButton.prop('disabled', true).text('Yoxlanır...');

        $.ajax({
            type: 'POST',
            url: $('#cvResume').attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                let modal = $('#messages');
                if (response.success) {
                    modal.find('.modal-message').html('<p style="color: #00aa18;font-weight: bold;">' + response.message + '</p>');
                    modal.find('.modal-message').removeClass('error').addClass('success fade-in');
                    modal.find('.modal-icon').html('<img src="' + '../site/icon/check.png' + '" style="max-width: 57px;" alt="Success" />');
                    modal.modal('show');
                } else {
                    modal.find('.modal-message').empty();
                    $.each(response.error, function (index, value) {
                        modal.find('.modal-message').append('<p style="font-weight: bold;">' + value + '</p>');
                    });
                    modal.find('.modal-message').removeClass('success').addClass('error fade-in');
                    modal.find('.modal-icon').html('<img src="' + '../site/icon/close.png' + '" style="max-width: 57px;" alt="Error" />');
                    modal.modal('show');
                }

                // Düyməni aktiv et və əvvəlki mətnə qaytar
                submitButton.prop('disabled', false).text('Şəkilinizi yenilə');
            },
            error: function (error) {
                let modal = $('#messages');
                modal.find('.modal-icon').html('<div class="btn-danger" style="text-align: center;">' + error + '</div>');
                modal.find('.modal-message').html('<div class="btn-danger" style="text-align: center;">' + error + '</div>');
                modal.find('.modal-message').removeClass('success').addClass('error fade-in');
                modal.find('.modal-icon').html('<img src="' + '../site/icon/close.png' + '" style="max-width: 57px;" alt="Error" />');
                modal.modal('show');

                // Düyməni aktiv et və əvvəlki mətnə qaytar
                submitButton.prop('disabled', false).text('Şəkilinizi yenilə');
            }
        });
    });
});
$(document).ready(function () {
    $('#cvMotivation').submit(function (e) {
        e.preventDefault();
        let submitButton = $('#buttonMotivation');
        // Düyməni deaktiv et və "Yoxlanılır..." yaz
        submitButton.prop('disabled', true).text('Yoxlanır...');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showModalMessage('success', response.message);
                    // 2 saniyə sonra səhifəni yenilə
                    setTimeout(function () {
                        location.reload();
                    }, 100);
                } else {
                    showModalMessage('error', response.errors || response.message);
                    submitButton.prop('disabled', false).text('Yadda saxla');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    showModalMessage('error', xhr.responseJSON.errors);
                } else {
                    showModalMessage('error', 'Xəta baş verdi.');
                }
                submitButton.prop('disabled', false).text('Yadda saxla');
            }
        });
    });
});

//end save

//start remove
document.querySelectorAll('.remove-skill').forEach(button => {
    button.addEventListener('click', function () {
        let skill = this.parentElement.textContent.trim().replace('×', '').trim(); // Tag dəyərini götür
        this.parentElement.remove(); // Ekrandan sil

        // AJAX ilə backend-ə göndər
        fetch('/remove-skill', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
            },
            body: JSON.stringify({ skill: skill })
        })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));
    });
});
document.querySelectorAll('.remove-language').forEach(button => {
    button.addEventListener('click', function () {
        let language = this.parentElement.textContent.trim().replace('×', '').trim(); // Tag dəyərini götür
        this.parentElement.remove(); // Ekrandan sil

        // AJAX ilə backend-ə göndər
        fetch('/remove-language', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
            },
            body: JSON.stringify({ language: language })
        })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));
    });
});
document.querySelectorAll('.remove-experience').forEach(button => {
    button.addEventListener('click', function () {
        let experience = this.parentElement.textContent.trim().replace('×', '').trim(); // Tag dəyərini götür
        this.parentElement.remove(); // Ekrandan sil

        // AJAX ilə backend-ə göndər
        fetch('/remove-experience', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
            },
            body: JSON.stringify({ experience: experience })
        })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));
    });
});
document.querySelectorAll('.remove-education').forEach(button => {
    button.addEventListener('click', function () {
        let education = this.parentElement.textContent.trim().replace('×', '').trim(); // Tag dəyərini götür
        this.parentElement.remove(); // Ekrandan sil

        // AJAX ilə backend-ə göndər
        fetch('/remove-education', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
            },
            body: JSON.stringify({ education: education })
        })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));
    });
});
document.querySelectorAll('.remove-project').forEach(button => {
    button.addEventListener('click', function () {
        let project = this.parentElement.textContent.trim().replace('×', '').trim(); // Tag dəyərini götür
        this.parentElement.remove(); // Ekrandan sil

        // AJAX ilə backend-ə göndər
        fetch('/remove-project', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
            },
            body: JSON.stringify({ project: project })
        })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));
    });
});
document.querySelectorAll('.remove-hobby').forEach(button => {
    button.addEventListener('click', function () {
        let hobby = this.parentElement.textContent.trim().replace('×', '').trim(); // Tag dəyərini götür
        this.parentElement.remove(); // Ekrandan sil

        // AJAX ilə backend-ə göndər
        fetch('/remove-hobby', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
            },
            body: JSON.stringify({ hobby: hobby })
        })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));
    });
});
document.querySelectorAll('.remove-social').forEach(button => {
    button.addEventListener('click', function () {
        let social = this.parentElement.textContent.trim().replace('×', '').trim(); // Tag dəyərini götür
        this.parentElement.remove(); // Ekrandan sil

        // AJAX ilə backend-ə göndər
        fetch('/remove-social', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
            },
            body: JSON.stringify({ social: social })
        })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));
    });
});
//end remove

function showModalMessage(type, messages) {
    let modal = $('#messages');
    let iconUrl = type === 'success'
        ? '../site/icon/check.png'
        : '../site/icon/close.png';

    let messageHtml = '';

    // Əgər message obyekt şəklindədirsə (validation errors)
    if (typeof messages === 'object') {
        Object.values(messages).forEach(function (msgArray) {
            msgArray.forEach(function (msg) {
                messageHtml += `<p style="margin:0 0 5px;color:#e00;font-weight:bold;">${msg}</p>`;
            });
        });
    } else {
        // Əgər sadə string mesajdırsa
        messageHtml = `<p style="margin:0;color:${type === 'success' ? '#00aa18' : '#e00'};font-weight:bold;">${messages}</p>`;
    }

    modal.find('.modal-message')
        .removeClass('success error fade-in')
        .addClass(type + ' fade-in')
        .html(messageHtml);

    modal.find('.modal-icon')
        .html(`<img src="${iconUrl}" style="max-width: 57px;" alt="${type}" />`);

    modal.modal('show');
}