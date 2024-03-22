jQuery(document).ready(function($){

    $('#user_per_page').on('change', function(){
        console.log($('#user_per_page').find(":selected").val());
        $('#user_form').submit();
    });
    
    $('#success .close').click(function(){
        $('#success').toast('hide');
    });
    $('#failed .close').click(function(){
        $('#failed').toast('hide');
    });

    $('#invite_staff_form').submit(function(event){

        event.preventDefault();
        let email = $('#new_user_email').val();

        $.ajax({
            type: 'POST',
            url: principal_object.ajax_url,
            data: {
                action: 'principal_staff_invitaions_by_email', 
                nonce : principal_object.nonce,
                userEmail: email,
            },
            success: function(response) {
                if(response) {
                    if(response == 'Verified') {
                        $('#success').toast('show');
                        $('.invitee_exits').hide().remove();
                        $('ul.invited-emails.list-group').append('<li class="list-group-item">'+ email +'</li>')
                    } else if(response == 'already_exits') {
                        $('#failed .toast-header h6').text('Already invited');
                        $('#failed .toast-body').text('This user already in your invited list');
                        $('#failed').toast('show');
                    } else {
                        $('#failed .toast-header h6').text('Email address not verified');
                        $('#failed .toast-body').text(response);
                        $('#failed').toast('show');
                    }
                } else {
                    console.warn('ajax error');
                }
            },
        });

    });

    $('#deputy_principal_form').submit(function(event){

        event.preventDefault();
        let email = $('#deputy_email').val();
        $.ajax({
            type: 'POST',
            url: principal_object.ajax_url,
            data: {
                action: 'delegate_to_deputy_principal', 
                nonce : principal_object.nonce,
                userEmail: email,
            },
            success: function(response) {
                if(response) {
                    if(response == 'Verified') {
                        $('#success').toast('show');
                        $('ul.invited-emails.list-group').append('<li class="list-group-item">'+ email +'</li>')
                    } else if(response == 'exits') {
                        let delegatedTo = principal_object.delegate_to_deputy_principal;
                        $('#failed .toast-header h6').text('Already delegated');
                        $('#failed .toast-body').text('You already delegated this task to this email ' + delegatedTo);
                        $('#failed').toast('show');
                    } else if(response == 'user_not_found'){
                        $('#failed .toast-header h6').text('This user not exits');
                        $('#failed .toast-body').text('Your Deputy Principal should be a GGSA member before you invite them');
                        $('#failed').toast('show');
                    } else {
                        $('#failed .toast-header h6').text('Email address not verified');
                        $('#failed .toast-body').text(response);
                        $('#failed').toast('show');
                    }
                } else {
                    console.warn('ajax error');
                }
            },
        });
    });

    $('#school_administrator_form').submit(function(event){

        event.preventDefault();
        let email = $('#administrator_email').val();
        $.ajax({
            type: 'POST',
            url: principal_object.ajax_url,
            data: {
                action: 'delegate_to_school_administrator', 
                nonce : principal_object.nonce,
                userEmail: email,
            },
            success: function(response) {
                if(response) {
                    if(response == 'Verified') {
                        $('#success').toast('show');
                        $('ul.invited-emails.list-group').append('<li class="list-group-item">'+ email +'</li>')
                    } else if(response == 'exits') {
                        let delegatedTo = principal_object.delegate_to_school_administrator;
                        $('#failed .toast-header h6').text('Already delegated');
                        $('#failed .toast-body').text('You already delegated this task to this email ' + delegatedTo);
                        $('#failed').toast('show');
                    } else if(response == 'user_not_found'){
                        $('#failed .toast-header h6').text('This user not exits');
                        $('#failed .toast-body').text('Your Deputy Principal should be a GGSA member before you invite them');
                        $('#failed').toast('show');
                    } else {
                        $('#failed .toast-header h6').text('Email address not verified');
                        $('#failed .toast-body').text(response);
                        $('#failed').toast('show');
                    }
                } else {
                    console.warn('ajax error');
                }
            },
        });
    });

    $('#choose-tab').click(function(e){
        e.preventDefault();
        $(this).text('Complete');
        $(this).attr('id', 'prinComBtn');
    })

    setInterval(changeButtonId, 2000);

    function changeButtonId(){
        $('#prinComBtn').click(function(e){
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: principal_object.ajax_url,
                data: {
                    action: 'complete_principal_onboarding_flow',
                    nonce: principal_object.nonce
                },
                success: function(response){
                    window.location.href = '/dashboard';
                }
            })
        })
    }



    // Example starter JavaScript for disabling form submissions if there are invalid fields

    'use strict';

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation');

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
    .forEach(function (form) {
        form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
        }
        form.classList.add('was-validated')
        }, false)
    });
   
    
});