jQuery( document ).ready(function($) {



    $('.search-clear').click(function(){
        $('#resourcesearch').val('');
        $('.search-clear').addClass('hidden');
        $('#search-resource').css('display', 'none');
    })

    $('#search-resource').hide();
    $('#resourcesearch').on('change', function(){

        let str = $(this).val();
        if (str.length > 3) {
            $.ajax({
                url: resources_object.ajax_url,
                type: 'GET',
                data: {
                    action: 'search_resource_get_hint',
                    nonce : resources_object.nonce,
                    q: str
                },
                beforeSend: function(){
                    $('.search-clear').removeClass('hidden');
                    $('.search-clear').text('Loading...');
                },
                success: function(response) {
                    if(response) {
                        $('#search-resource').css('display', 'block');
                        $('#search-resource').html(response);
                        $('.search-clear').text('Clear');
                        $('.search-clear').removeClass('hidden');
                        $('.suggestion-container h5.title-course').each(function(){
                            let title = $(this).text();
                            let regex = new RegExp(str, 'gi');
                            let newHTML = title.replace(regex, '<span class="found">'+ str +'</span>');
                            $(this).html(newHTML);
                        });
                    }
                }
            });
        } else {
            $('#search-resource').hide();
            $('.search-clear').addClass('hidden');
            return;
        }
    })
    
    $('#completeButton').hide();
  
    $('#nextButton').click(function(e){
        e.preventDefault();
        $('#pills-welcome-content').removeClass('active');
        $('a#pills-onboarding-content').addClass('active');
        $('#pills-welcome').removeClass('active show');
        $('#pills-onboarding').addClass('active show');
        $(this).hide();
        $('#completeButton').show();
        $('.onboarding-header-body.step-one').hide();
        $('.onboarding-header-body.step-two').show();
  
    });
    
    $('#pills-onboarding-content').click(function(){
        $('#nextButton').hide();
        $('#completeButton').show();
        $('.onboarding-header-body.step-one').hide();
        $('.onboarding-header-body.step-two').show();
  
    });
    
    $('#pills-welcome-content').click(function(){
        $('#nextButton').show();
        $('#completeButton').hide();
        $('.onboarding-header-body.step-one').show();
        $('.onboarding-header-body.step-two').hide();
    });
  
    let curr_length = $('#library-1 .item-course').length;
    if(curr_length > 0){
         $('#library-1 .empty-library').hide();
     }  
  
     let pr_length = $('#library-2 .item-course').length;
     if(pr_length > 0){
       $('#library-2 .empty-library').hide();
     }
  
     let si_length = $('#library-3 .item-course').length;
     if(si_length > 0){
       $('#library-3 .empty-library').hide();
     }
  });
  
  document.addEventListener('DOMContentLoaded', function () {
    const arrows = document.querySelectorAll('.arrow');
  
    arrows.forEach(arrow => {
        arrow.addEventListener('click', function () {
            const container = this.closest('.curriculum-table-container');
            const content = container.querySelector('.hidden-content');
            if (this.style.transform === 'rotate(180deg)') {
                this.style.transform = 'rotate(0deg)';
            } else {
                this.style.transform = 'rotate(180deg)';
            }
  
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                content.classList.add('block');
            } else {
                content.classList.add('hidden');
                content.classList.remove('block')
            }
        });
    });
  });
    
  jQuery( document ).ready(function($) {

    const allResouceArray = [];
    let uniqueResouceArray = [];
    
    const resourceLimit = document.querySelector('.res_quantity');
    const enrollQuantity = document.querySelector('.enroll-qty');
    const currentSelection = document.querySelector('.current_selection');
    const courseToGo = document.querySelector('.course_to_go');
    let prevEnrollQuantity = parseInt(enrollQuantity.innerHTML);
    let resourceLimitQuantity = parseInt(resourceLimit.innerHTML);
    let currentSelectionQuantity = parseInt(currentSelection.innerHTML);

    if(currentSelectionQuantity >= resourceLimitQuantity){
        $('#add_to_library').attr('disabled', 'disabled');
        // $('.course_checked_id').attr( "disabled" ,"disabled");
    }
  
    $('#curriculum').on('click', '.course_checked_id', function(){
        let clickedItem = $(this);
        let courseID = clickedItem.attr('id');

        if(clickedItem.prop('checked')) {
            if(prevEnrollQuantity < resourceLimitQuantity){
                $('input#' + courseID + '+ .plus-checkbox').attr( "title" ,"deselect");
                prevEnrollQuantity++;
                enrollQuantity.innerHTML = prevEnrollQuantity;
                $.ajax({
                    type: 'POST',
                    url: resources_object.ajax_url,
                    data: {
                        action: 'add_curr_user_onboarding',
                        nonce : resources_object.nonce,
                        course_id: courseID, 
                    },
                    success: function(response) {
                        if(response) {
                        $('#library-1 .empty-library').hide();
                        $('#library-1 .list-course').append(response).hide().fadeIn(250);
                        }
                    },
                });
                allResouceArray.push(courseID);
            } else {
                $('#limitModel').modal('show');
                this.checked = false;
                }
          } else {
            prevEnrollQuantity--;
            enrollQuantity.innerHTML = prevEnrollQuantity;
            $('input#' + courseID + '+ .plus-checkbox').attr( "title" ,"select");
            $.ajax({
                type: 'POST',
                url: resources_object.ajax_url,
                data: {
                    action: 'remove_curr_user_onboarding', 
                    nonce : resources_object.nonce,
                    course_id: courseID, 
                },
                success: function(response) {
                    if(response) {
                      $('.on-ur-library-' + courseID).fadeOut(250).remove();
                         let curr_length = $('#library-1 .item-course').length;
                         if(curr_length ==	0){
                              $('#library-1 .empty-library').show();
                          }
                    }
                },
            });
              const clickedItemIndex = allResouceArray.indexOf(courseID);
              if(clickedItemIndex !== -1) {
                allResouceArray.splice(clickedItemIndex, 1);
              }
          }
        uniqueResouceArray = Array.from(new Set(allResouceArray));
        currentSelection.innerHTML = prevEnrollQuantity;
        courseToGo.innerHTML = resourceLimitQuantity - prevEnrollQuantity;

    })
    
    
    $('#professional-learning').on('click', '.course_checked_id', function(){
        let clickedItem = $(this);
        let courseID = clickedItem.attr('id');

        if(clickedItem.prop('checked')) {
            if(prevEnrollQuantity < resourceLimitQuantity){
                prevEnrollQuantity++;
                enrollQuantity.innerHTML = prevEnrollQuantity;
                $('input#' + courseID + '+ .plus-checkbox').attr( "title" ,"deselect");
                $.ajax({
                    type: 'POST',
                    url: resources_object.ajax_url,
                    data: {
                        action: 'add_pro_lern_user_onboarding', 
                        nonce : resources_object.nonce,
                        course_id: courseID, 
                    },
                    success: function(response) {
                        if(response) {
                          $('#library-2 .empty-library').hide();
                          $('#library-2 .list-course').append(response).hide().fadeIn(250);
                        }
                    },
                });
                allResouceArray.push(courseID);
            } else {
                $('#limitModel').modal('show');
                this.checked = false;
                }
          } else {
            prevEnrollQuantity--;
            enrollQuantity.innerHTML = prevEnrollQuantity;
            $('input#' + courseID + '+ .plus-checkbox').attr( "title" ,"select");
            $.ajax({
                type: 'POST',
                url: resources_object.ajax_url, 
                data: {
                    action: 'remove_pro_lern_user_onboarding', 
                    nonce : resources_object.nonce,
                    course_id: courseID,
                },
                success: function(response) {
                    if(response) {
                      $('.on-ur-library-' + courseID).fadeOut(250).remove();
                         let pr_length = $('#library-2 .item-course').length;
                          if(pr_length == 0){
                            $('#library-2 .empty-library').show();
                          }
                    }
                },
            });
            const clickedItemIndex = allResouceArray.indexOf(courseID);
            if(clickedItemIndex !== -1) {
                allResouceArray.splice(clickedItemIndex, 1);
            }
          }
        uniqueResouceArray = Array.from(new Set(allResouceArray));
        currentSelection.innerHTML = prevEnrollQuantity;
        courseToGo.innerHTML = resourceLimitQuantity - prevEnrollQuantity;

    });

    $('#school-improvement').on('click', '.course_checked_id', function(){
        let clickedItem = $(this);
        let courseID = clickedItem.attr('id');

        if(clickedItem.prop('checked')) {
            if(prevEnrollQuantity < resourceLimitQuantity){
                prevEnrollQuantity++;
                enrollQuantity.innerHTML = prevEnrollQuantity;
                $('input#' + courseID + '+ .plus-checkbox').attr( "title" ,"deselect");
                $.ajax({
                    type: 'POST',
                    url: resources_object.ajax_url,
                    data: {
                        action: 'add_scl_imp_user_onboarding',
                        nonce : resources_object.nonce,
                        course_id: courseID,
                    },
                    success: function(response) {
                        if(response) {
                        $('#library-3 .empty-library').hide();
                        $('#library-3 .list-course').append(response).hide().fadeIn(250);
                        }
                    },
                });
                allResouceArray.push(courseID);
            } else {
                    $('#limitModel').modal('show');
                    this.checked = false;
                }  
          } else {
            prevEnrollQuantity--;
            enrollQuantity.innerHTML = prevEnrollQuantity;
            $('input#' + courseID + '+ .plus-checkbox').attr( "title" ,"select");
                $.ajax({
                    type: 'POST',
                    url: resources_object.ajax_url,
                    data: {
                        action: 'remove_scl_imp_user_onboarding', 
                        nonce : resources_object.nonce,
                        course_id: courseID,
                    },
                    success: function(response) {
                        if(response) {
                        $('.on-ur-library-' + courseID).fadeOut(250).remove();
                            let si_length = $('#library-3 .item-course').length;
                            if(si_length == 0){
                                $('#library-3 .empty-library').show();
                            }
                        }
                    },
                });
              const clickedItemIndex = allResouceArray.indexOf(courseID);
              if(clickedItemIndex !== -1) {
                  allResouceArray.splice(clickedItemIndex, 1); 
              }
          }
      uniqueResouceArray = Array.from(new Set(allResouceArray)); 
      currentSelection.innerHTML = prevEnrollQuantity;
      courseToGo.innerHTML = resourceLimitQuantity - prevEnrollQuantity;

    });

    // functions to run on click
    // enroll all selected course to the user
    $('#completeButton').click(function(){
        $.ajax({
            type: 'POST',
            url: resources_object.ajax_url,
            data: {
                action: 'enroll_user_from_onboarding_page', 
                nonce : resources_object.nonce,
                course_array: uniqueResouceArray, 
            },
            success: function(response) {
                if(response) {
                    location.href = '/dashboard';
                }
            },
        });
    })

    // getting all selected course checkbox
    // disable all selected course checkbox 
    $.ajax({
        type: 'GET',
        url: resources_object.ajax_url,
        data: {
            action: 'preselected_course_ids', 
            nonce : resources_object.nonce,
        },
        success: function(response) {
            if(response) {
                data = JSON.parse(response);
                for(let i=0; i < data.length; i++) {
                    $('input#' + data[i]).attr( "checked" ,"checked");
                    $('input#' + data[i]).attr( "disabled" ,"disabled");
                }
                    $('input[type="checkbox"]:disabled + .plus-checkbox').each(function(){
                        $(this).attr('title', 'You can\'t unselect enroll course');
                    })
            } else {
                console.log('Onbaording Js "preselected_course_ids" error ');
            }
        },
    });


    // enroll user to the selected course when they click on Add to Library
   $('#add_to_library').click(function(){
    $.ajax({
            type: 'POST',
            url: resources_object.ajax_url,
            data: {
                action: 'enroll_user_from_resources_page', 
                nonce : resources_object.nonce,
                course_array: uniqueResouceArray, 
            },
            success: function(response) {
                if(response) {
                    location.reload();
                    // console.log('course_enrolled');
                }
            },
        });
    })

  })

