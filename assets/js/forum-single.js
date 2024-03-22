jQuery(document).ready(function($){

    $('.comment-reply').each(function(){
        $(this).submit(function(e){
            e.preventDefault();
        
            commentParentId = $(this).attr('id');
            replyText = $('#reply-text-' + commentParentId).val();
            post_id = $('#post-' + commentParentId).val();
            
            $.ajax({
                type: 'POST',
                url: sf_object.ajax_url,
                data: {
                    action: 'add_discussion_comment_reply', 
                    // nonce : sf_object.nonce,
                    post_id: post_id,
                    parent_id: commentParentId,
                    reply_text: replyText,
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
                    
                },
                error: function(error) {
                    console.log(error)
                }
            }); 
        
        });
    });

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

    $('.top-res-com').each(function(){
        $(this).click(function(){
            $(this).parents('.top-res-action').siblings('.top-res-reply').toggleClass('d-none');
        })
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
    });

    if (window.history && window.history.length > 1) {
        $('.go-back').click(function(){
            history.back();
        });
    } else {
        $('.go-back').attr('disabled', 'disabled');
    }  

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
                    window.location.href = '/expert-forum';
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

})