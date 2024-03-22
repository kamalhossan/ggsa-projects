tailwind.config = {
    theme: {
      extend: {
        colors: {
          navy: "#00859C",
          orange: "#FAA332",
          standard: "#1B61F9",
          green: "#5BC04E",
          yellow: "#FBBC16",
        },
      },
    },
  };
  
  $(document).ready(function () {
      
      function setCookie(cname, cvalue, exdays) {
          var d = new Date();
          d.setTime(d.getTime() + (exdays*24*60*60*1000));
          var expires = "expires="+ d.toUTCString();
          document.cookie = cname + "=" + cvalue + "; " + expires;
      }
  
      $('.icon-notification,.notification .close-button').on('click', function () {
          $('.notification').toggle();
  
      });
      jQuery('.rs-slider').each(function (e, i) {
          let prev = jQuery(this).find('.prev-ar').eq(0);
          let next = jQuery(this).find('.next-ar').eq(0);
          let number = $(this).data('key');
          let dot = $(this).find('.dot').eq(0);
          let slider = $(this).find('.ss-slider').eq(0);
          slider.slick({
              infinite: false,
              slidesToShow: number,
              slidesToScroll: number,
              arrows: true,
              dots: true,
              prevArrow: prev,
              nextArrow: next,
              appendDots: dot,
              // autoplay: true,
              // autoplaySpeed: 2000,
              infinite: true,
  
          });
  
  
  
      });
      $('.mark-read').on('click', function () {
  
          $.ajax({
              url: aj_object.ajaxurl, // WordPress AJAX URL
              type: 'POST',
              data: {
                  action: 'mark_read', // The AJAX action name
  
                  // Additional data to send if needed
              },
              success: function (response) {
                  // Handle the AJAX response
  
                  $('.msg').removeClass('msg-0').addClass('msg-1');
                  $('.icon-notification span').html(0);
              },
              error: function (xhr, status, error) {
                  // Handle error
                  console.log(error);
              }
          });
      });

      /*BY KAMAL START*/
      $('#topic-like').on('click', function () {
        $.ajax({
            url: ld_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'topic_likes_action',
                topicId: ld_object.topic_id,
            },
            success: function (response) {
              if(response.trim() === 'unlike'){
                $('#topic-like').toggleClass('liked');
                likes = $('.number').text();
                likesCount = parseInt(likes);
                likesCount--;
                if(likesCount == 0 || isNaN(likesCount)){
                  $('.number').text('');
                } else {
                  $('.number').text(likesCount);
                }
              } else {
                $('#topic-like').toggleClass('liked');
                likes = $('.number').text();
                likesCount = parseInt(likes);
                if(isNaN(likesCount)){
                  $('.number').text(1);
                } else {
                  likesCount++;
                  $('.number').text(likesCount);
                }
              }
              console.log(response)
            },
            error: function (xhr, status, error) {
                // Handle error
                console.log(error);
            }
        });
      });

    $('#mistake-submit').submit('click', function (e) {
      e.preventDefault();
      details = $('#details').val();
      mistakeType = $('input[name="mistaketype"]:checked').val();

        $.ajax({
            url: ld_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'report_mistakes', 
                topicId: ld_object.topic_id,
                type: mistakeType,
                details: details,
            },
            success: function (response) {
                $('#report-' + ld_object.topic_id).modal('hide');
                $('.modal-backdrop').remove();
                // console.log(response);
            },
            error: function (xhr, status, error) {
                // Handle error
                console.log(error);
            }
        });
    });

    $('.progress-bar').each(function(){
        maxValue = $(this).attr('aria-valuemax');
        rating =  $(this).siblings().html();
        percent = rating / maxValue * 100;
        if(isNaN(percent)){
            $(this).css('width', '100%');
        } else {
            $(this).css('width', percent + '%');
        }
    })

    $("#review").keyup(function(){
        $("#char-limit").text("Characters left: " + (500 - $(this).val().length));
    });

    $('.rating-star').click(function(){
        rating = $(this).attr('data-rating');
        for(let i = 0; i < rating; i++){
            counter = i + 1;
            src = $('.rating-' + counter).attr('src', '/wp-content/themes/GGSA/assets/svg/star-filled.svg');
        }
        for(let i = 5; i > rating; i--){
            src = $('.rating-' + i).attr('src', '/wp-content/themes/GGSA/assets/svg/star.svg');
        }
        $('#rating-number').val(rating);
    })
    $('.dot-nav').click(function(){
        id = $(this).attr('id')
        $('#toast-' + id).toast('show');
    })

    $('#rating-submit').submit('click', function (e) {
      e.preventDefault();
      
      rating = $('input[name="user-rating"]:checked').val();
      feedback =  $("#review").val();
        $.ajax({
            url: ld_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'leave_a_rating_for_topic', 
                topicId: ld_object.topic_id,
                rating: rating,
                feedback: feedback,
            },
            success: function (response) {
                $('#feedback').modal('hide');
                $('.modal-backdrop').remove();
                location.reload();
                // console.log(response);

            },
            error: function (xhr, status, error) {
                // Handle error
                console.log(error);
            }
        });
    });

    $('#review-filter').on('change', function(){
      console.log($(this).val());
      $('#filter_form').submit();
    })

    $('#start-a-discussion').click(function(){
      $('.create-form').toggleClass('d-none');
    });

    $('#new-discussion').submit(function(e){
      e.preventDefault();
      console.log('discussion form submitted');
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


    $('.save-diss').each(function(){
      $(this).click(function(){
          clickedItem = $(this);
        
          $.ajax({
              type: 'POST',
              url: ld_object.ajaxurl,
              data: {
                  action: 'self_user_save_disscussion',
                  nonce : ld_object.nonce,
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

    $('#new-discussion').submit(function(e){
      e.preventDefault();
      $.ajax({
          type: 'POST',
          url: ld_object.ajaxurl,
          data: {
              action: 'start_a_discussion_on_peer_forum', 
              nonce : ld_object.nonce,
              courseId: $('#topic-course-id').val(),
              topicId: $('#topic-id').val(),
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

    $('#new-question').submit(function(e){
      e.preventDefault();
      $.ajax({
          type: 'POST',
          url: ld_object.ajaxurl,
          data: {
              action: 'start_a_question_on_expert_forum', 
              nonce : ld_object.nonce,
              courseId: $('#ques-course-id').val(),
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

    $('#topic-peer-sort').change(function(){
      $('#sort-peer-forums').submit();
    })
    $('#question-expert-sort').change(function(){
      $('#sort-expert-forums').submit();
    })

    $('.post-like').each(function(){
        $(this).click(function(){
          
            clickedItem = $(this);
            id = $(this).attr('id');

            $.ajax({
                type: 'POST',
                url: ld_object.ajaxurl,
                data: {
                    action: 'post_likes_action',
                    nonce : ld_object.nonce,
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

    $('.reportBtn').each(function(){
      $(this).click(function(){
          id = $(this).attr('id');
          $('#reportSpam').modal('show');

          $('#spam-report').submit(function(e){
              e.preventDefault();

              $.ajax({
                  type: 'POST',
                  url: ld_object.ajaxurl,
                  data: {
                      action: 'report_topics_and_questions',
                      nonce : ld_object.nonce,
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

    $('.parent-answer').each(function(){
        $(this).submit(function(e){
            e.preventDefault();
        
            post_id = $(this).attr('id');
 
            $.ajax({
                type: 'POST',
                url: ld_object.ajaxurl,
                data: {
                    action: 'add_discussion_parent_comment', 
                    nonce : ld_object.nonce,
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

    $('.qus-ans').each(function(){
        $(this).click(function(){
            $(this).parents('.question-bottom').siblings('.question-answers').toggleClass('d-none');
        })
    })
  



    /*BY KAMAL END*/

  });
  $(document).click(function (event) {
    const notification = $('.notification');
    const iconnotification = $('.icon-notification');
    const targetElement = event.target;
  
    // Check if the clicked element is not inside the panel
    if (!notification.is(targetElement) && !iconnotification.is(targetElement) && notification.has(targetElement).length === 0 && iconnotification.has(targetElement).length === 0) {
      // Hide the panel
  
      if (notification.css('display') !== 'none') {
        notification.hide();
      }
    }
  });
  
  $('.item-menu.has-sub-menu').on('click', function () {
    var menu = $(this);
    menu.toggleClass('active-sub');
  });

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