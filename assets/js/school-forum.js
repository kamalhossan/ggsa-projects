jQuery(document).ready(function($){

    if (window.history && window.history.length > 1) {
        $('.go-back').click(function(){
            history.back();
        });
    } else {
        $('.go-back').attr('disabled', 'disabled');
    }

    $('#start-a-discussion').click(()=>{
        $('.create-form').toggleClass('d-none');
    })
    $('#ask-a-question').click(()=>{
        $('.create-form').toggleClass('d-none');
    })
    $('.create-cancel').click(()=>{
        $('.create-form').toggleClass('d-none');
    })
    $('.curr-qus-ans').each(function(){
        $(this).click(function(){
            $(this).parents('.question-bottom').siblings('.question-answers').toggleClass('d-none');
        })
    })

    $('#forum-search').keyup(function(){

        val = $(this).val();

        if(val.length >= 3){
            $.ajax({
                type: 'POST',
                url: sf_object.ajax_url,
                data: {
                    action: 'search_topic_and_question_across_term',
                    search_val: val
                }, 
                beforeSend: function(){
                    $('.search-clear').removeClass('hidden');
                    $('.search-clear').text('Loading...');
                },
                success: function(response){
                    if(response){
                        $('.search-clear').text('Clear');
                        $('#search-forum').removeClass('d-none');
                        $('#search-forum').html(response);
                    }
                },
                error: function(error){
                    console.log(error)
                }
            })
        } else {
            $('#search-forum').addClass('d-none');
            $('.search-clear').addClass('hidden');
        }

    })
    
    $('.search-clear').click(function(){
        $('#forum-search').val('');
        $('#search-forum').addClass('d-none');
        $('.search-clear').addClass('hidden');
    })


    $('.save-diss').each(function(){
        $(this).click(function(){
            clickedItem = $(this);
          
            $.ajax({
                type: 'POST',
                url: sf_object.ajax_url,
                data: {
                    action: 'self_user_save_disscussion',
                    nonce : sf_object.nonce,
                    postNumber: $(this).attr('id'),
                },
                success : function(data){
                    oldSrc = clickedItem.children('img').attr('src');
                    if(oldSrc.match('saved')){
                        unsavedImg = oldSrc.replace('saved','unsaved');
                        clickedItem.children('img').attr('src',unsavedImg);
                    }
                    if(oldSrc.match('unsaved')) {
                        saveImg = oldSrc.replace('unsaved','saved');
                        clickedItem.children('img').attr('src',saveImg);
                    }
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });
        });
    })

    $("#forum-qus-desc").keyup(function(){
        maxChar = 500;
        if($(this).val().length > maxChar){
            $(this).val($(this).val().substring(0, maxChar));
        } else {
            $("#char-limit-qus").text($(this).val().length + '/500');
        }
    });
    
    $("#forum-desc").keyup(function(){
         maxChar = 500;
        if($(this).val().length > maxChar){
            $(this).val($(this).val().substring(0, maxChar));
        } else {
            $("#char-limit").text($(this).val().length + '/500');
        }
    });

    $("#forum-title").keyup(function(){
         maxChar = 80;
        if($(this).val().length > maxChar){
            $(this).val($(this).val().substring(0, maxChar));
        } else {
            $("#title-limit").text($(this).val().length + '/80');
        }
    });

    $('.reportBtn').each(function(){
        $(this).click(function(){
            id = $(this).attr('id');
            $('#reportSpam').modal('show');

            $('#spam-report').submit(function(e){
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: sf_object.ajax_url,
                    data: {
                        action: 'report_topics_and_questions',
                        nonce : sf_object.nonce,
                        postNumber: id,
                        spamType: $('input[name=reportSpamField]:checked').val(),
                        issueDetails: $('#issueDetails').val(),
                    },
                    success : function(data){
                        if(data){
                            $('#reportSpam').modal('hide');
                        }
                    },
                    error: function(errorThrown){
                        console.log(errorThrown);
                    }
                });

            }) 
        })
    });

    $('#new-discussion').submit(function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: sf_object.ajax_url,
            data: {
                action: 'start_a_discussion_on_peer_forum', 
                nonce : sf_object.nonce,
                courseId: $('#courseid').val(),
                topicId: $('#topicid').val(),
                title: $('#forum-title').val(),
                content: $('#forum-desc').val(),
            },
            beforeSend: function() {
                $('#diss-create').attr('disabled', 'disabled');
            },
            success: function(response) {
                if(response) {
                    console.log(response)
                    location.reload();
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $('.post-like').each(function(){
        $(this).click(function(){
           
            clickedItem = $(this);
            id = $(this).attr('id');

            $.ajax({
                type: 'POST',
                url: sf_object.ajax_url,
                data: {
                    action: 'post_likes_action',
                    nonce : sf_object.nonce,
                    postId: id,
                },
                success: function (response) {
                    if(response){
                        oldSrc = clickedItem.children('img').attr('src');
                        if(oldSrc.match('like')){
                            unlike = oldSrc.replace('like','unlike');
                            clickedItem.children('img').attr('src',unlike);
                        }
                        if(oldSrc.match('unlike')) {
                            saveImg = oldSrc.replace('unlike','like');
                            clickedItem.children('img').attr('src',saveImg);
                        }
                        if(response == 0){
                            clickedItem.children('.number').text('');
                        } else {
                            clickedItem.children('.number').text(response);
                        }
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error
                    console.log(error);
                }
            });
        })
    })


    $('#new-question').submit(function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: sf_object.ajax_url,
            data: {
                action: 'start_a_question_on_expert_forum', 
                nonce : sf_object.nonce,
                courseId: $('#forum-qus-name').val(),
                content: $('#forum-qus-desc').val(),
            },
            beforeSend: function() {
                $('#ques-create').attr('disabled', 'disabled');
            },
            success: function(response) {
                if(response) {
                    console.log(response)
                    location.reload();
                }
            },
            error: function(error) {
                console.log(error)
            }
        }); 
    });

    $('.no').each(function(){
        $(this).click(function(){
            $(this).parents('.delete-confirmation').toggleClass('d-none');
            $(this).parents('.delete-confirmation').siblings('.delete-forum').toggleClass('d-none');
        })
    })
    $('.yes').each(function(){
        $(this).click(function(){
            id = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: sf_object.ajax_url,
                data: {
                    action: 'self_delete_expert_forum',
                    nonce : sf_object.nonce,
                    postNumber: id,
                },
                success : function(data){
                    console.log(data)
                    location.reload();
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });
        })
    })

    $('.delete-forum').each(function(){
        $(this).click(function(){
            $(this).toggleClass('d-none');
            $(this).siblings('.delete-confirmation').toggleClass('d-none');
        })
    })

    $('.qus-ans').each(function(){
        $(this).click(function(){
            $(this).parents('.question-bottom').siblings('.question-answers').toggleClass('d-none');
        })
    })


    $('.parent-answer').each(function(){
        $(this).submit(function(e){
            e.preventDefault();
        
            post_id = $(this).attr('id');
 
            $.ajax({
                type: 'POST',
                url: sf_object.ajax_url,
                data: {
                    action: 'add_discussion_parent_comment', 
                    nonce : sf_object.nonce,
                    postId: post_id,
                    commentText: $('#answer-text-' + post_id).val(),
                },
                success: function(response) {
                    if(response) {
                        console.log(response)
                        location.reload();
                    }
                },
                error: function(error) {
                    console.log(error)
                }
            });
        })  
    })



    $('#parent-comment').submit(function(e){
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: sf_object.ajax_url,
            data: {
                action: 'add_discussion_parent_comment', 
                nonce : sf_object.nonce,
                postId: $('#post-id').val(),
                commentText: $('#p-comment-text').val(),
            },
            success: function(response) {
                if(response) {
                    console.log(response)
                    location.reload();
                }
            },
            error: function(error) {
                console.log(error)
            }
        }); 
    })

    const userCourse = [];
    const userTopics = [];

    $.ajax({
        type: 'GET',
        url: sf_object.ajax_url,
        data: {
            action: 'user_enrolled_data_for_forum', 
            nonce : sf_object.nonce,
        },
        success: function(data) {
            if(data) {
                userCourse.push(data.user_course_names);
                userTopics.push(data.user_topics_name);
                userCourse[0].forEach(course => {
                    let PeerOption = $('<option>', {
                        value: course.id,
                        text: course.course_title
                    });
                    $('#courseid').append(PeerOption);
                    let ExpertOption = $('<option>', {
                        value: course.id,
                        text: course.course_title
                    });
                    $('#forum-qus-name').append(ExpertOption);
                });
                console.log('get works');
            }
        },
        error: function(error) {
            console.log(error);
        }
    });

    $('.top-res-com').each(function(){
        $(this).click(function(){
            $(this).parents('.top-res-action').siblings('.top-res-reply').toggleClass('d-none');
        })
    })

    $('.com-res-like').each(function(){
        $(this).click(function(){
            id = $(this).attr('id');
            clickedItem = $(this);
            // console.log(id);

            $.ajax({
                type: 'POST',
                url: sf_object.ajax_url,
                data: {
                    action: 'comment_reply_like_count', 
                    nonce : sf_object.nonce,
                    commentId: id,
                },
                success: function(response) {
                    if(response){
                        oldSrc = clickedItem.children('img').attr('src');
                        if(oldSrc.match('like')){
                            unlike = oldSrc.replace('like','unlike');
                            clickedItem.children('img').attr('src',unlike);
                        }
                        if(oldSrc.match('unlike')) {
                            saveImg = oldSrc.replace('unlike','like');
                            clickedItem.children('img').attr('src',saveImg);
                        }
                        if(response == 0){
                            clickedItem.children('.number').text('');
                        } else {
                            clickedItem.children('.number').text(response);
                        }
                    }
                     // location.reload();
                    
                },
                error: function(error) {
                    console.log(error)
                }
            }); 
        
        });
    });

    $(document).on('change', '#courseid', function(){
        const selectedCourse = $('#courseid').val();
        var selectedCourseString = selectedCourse.toString();
        if(userTopics[0].hasOwnProperty(selectedCourseString)){
            userTopics[0][selectedCourse].forEach(topic => {
                console.log(topic);
                console.log(topic.topic_name);
                const option = $('<option>', {
                    value: topic.topic_id,
                    text: topic.topic_name
                });
                $('#topicid').append(option);
            }); 
        } else {
            $('#topicid option:not(:disabled)').remove();
        }   
    });

    $('#peer-sort').change(function(){
        $('#peer-search').submit();
    })
    $('#expert-sort').change(function(){
        $('#expert-search').submit();
    })
    $('#chats-sort').change(function(){
        $('#chats-search').submit();
    })

})
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
    'use strict'
  
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')
  
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
      })
  })()