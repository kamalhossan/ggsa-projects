jQuery( document ).ready(function($) {

   
    // $('#completeButton').hide();
  
   
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
  const currentSelection = document.querySelector('.onboarding_current_selection');
  const courseToGo = document.querySelector('.course_to_go');
  let resourceLimitQuantity = parseInt(resourceLimit.innerHTML);
  let currentSelectionQuantity = parseInt(currentSelection.innerHTML);
  
  
  if(currentSelectionQuantity >= resourceLimitQuantity){
      $('#add_to_library').attr('disabled', 'disabled');
      // $('.course_checked_id').attr( "disabled" ,"disabled");
  }
  
    let curriculumInput = document.querySelectorAll('#curriculum .course_checked_id');
  
    for(let i=0; i < curriculumInput.length; i++) {
        curriculumInput[i].addEventListener('click', function(){
  
            let clickedItem = curriculumInput[i];
            let courseID  = clickedItem.id;
      
                if(clickedItem.checked) {
                  if(currentSelectionQuantity + uniqueResouceArray.length < resourceLimitQuantity){
                      $('input#' + courseID + '+ .plus-checkbox').attr( "title" ,"deselect");
                      $.ajax({
                          type: 'POST',
                          url: onboarding_object.ajax_url,
                          data: {
                              action: 'add_curr_user_onboarding',
                              nonce : onboarding_object.nonce,
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
                  $('input#' + courseID + '+ .plus-checkbox').attr( "title" ,"select");
                  $.ajax({
                      type: 'POST',
                      url: onboarding_object.ajax_url,
                      data: {
                          action: 'remove_curr_user_onboarding', 
                          nonce : onboarding_object.nonce,
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
              let youHaveSelected = currentSelectionQuantity + uniqueResouceArray.length;
              let canEnroll = resourceLimitQuantity - currentSelectionQuantity;
              if(currentSelectionQuantity < 1){ 
                  enrollQuantity.innerHTML = uniqueResouceArray.length;
                  currentSelection.innerHTML = uniqueResouceArray.length;
                  courseToGo.innerHTML = resourceLimitQuantity - uniqueResouceArray.length;
              }  else {     
                  enrollQuantity.innerHTML = youHaveSelected;
                  currentSelection.innerHTML = youHaveSelected;
                  courseToGo.innerHTML = canEnroll - uniqueResouceArray.length;   
              }   
              if(canEnroll - uniqueResouceArray.length == 0){
                  $('#add_to_library').attr('disabled', 'disabled');
                    $('#completeButton').fadeOut(500);
                    $('#completeButton').fadeIn(500);
                    $('#completeButton').fadeOut(500);
                    $('#completeButton').fadeIn(500);
                    $('.instruct').text('Complete')
                  } else {
                    $('#add_to_library').removeAttr('disabled');
                    $('.instruct').text('Add to Library')
              }
        });
    }
  
    // professional learning
    let proLearningInput = document.querySelectorAll('#professional-learning .course_checked_id');
  
    for(let i=0; i < proLearningInput.length; i++) {
        proLearningInput[i].addEventListener('click', function(){
            let clickedItem = proLearningInput[i];
            let courseID  = clickedItem.id;
            
                if(clickedItem.checked) {
                  if(currentSelectionQuantity + uniqueResouceArray.length < resourceLimitQuantity){
                      $('input#' + courseID + '+ .plus-checkbox').attr( "title" ,"deselect");
                      $.ajax({
                          type: 'POST',
                          url: onboarding_object.ajax_url,
                          data: {
                              action: 'add_pro_lern_user_onboarding', 
                              nonce : onboarding_object.nonce,
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
                  $('input#' + courseID + '+ .plus-checkbox').attr( "title" ,"select");
                  $.ajax({
                      type: 'POST',
                      url: onboarding_object.ajax_url, 
                      data: {
                          action: 'remove_pro_lern_user_onboarding', 
                          nonce : onboarding_object.nonce,
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
                let youHaveSelected = currentSelectionQuantity + uniqueResouceArray.length;
                let canEnroll = resourceLimitQuantity - currentSelectionQuantity;
                if(currentSelectionQuantity < 1){ 
                    enrollQuantity.innerHTML = uniqueResouceArray.length;
                    currentSelection.innerHTML = uniqueResouceArray.length;
                    courseToGo.innerHTML = resourceLimitQuantity - uniqueResouceArray.length;
                }  else {     
                    enrollQuantity.innerHTML = youHaveSelected;
                    currentSelection.innerHTML = youHaveSelected;
                    courseToGo.innerHTML = canEnroll - uniqueResouceArray.length;   
                }   
                if(canEnroll - uniqueResouceArray.length == 0){
                    $('#add_to_library').attr('disabled', 'disabled');
                    $('#completeButton').fadeOut(500);
                    $('#completeButton').fadeIn(500);
                    $('#completeButton').fadeOut(500);
                    $('#completeButton').fadeIn(500);
                    $('.instruct').text('Complete')
                  } else {
                    $('#add_to_library').removeAttr('disabled');
                    $('.instruct').text('Add to Library')
                }
        });
    }
  
  
    // school improvement
  
    let schoolResourceArray = [];
    let schoolUniqueCourseIDs = [];
    let schoolResourceLimit = document.querySelector('#school-improvement .limit');
    let schoolResourceQty = document.querySelector('#school-improvement span.resource_qty');
    let schoolLearningInput = document.querySelectorAll('#school-improvement .course_checked_id');
  
    for(let i=0; i < schoolLearningInput.length; i++) {
        schoolLearningInput[i].addEventListener('click', function(){
  
            let clickedItem = schoolLearningInput[i];
            let courseID  = clickedItem.id;
            
                if(clickedItem.checked) {
                  if(currentSelectionQuantity + uniqueResouceArray.length < resourceLimitQuantity){
                      $('input#' + courseID + '+ .plus-checkbox').attr( "title" ,"deselect");
                      $.ajax({
                          type: 'POST',
                          url: onboarding_object.ajax_url,
                          data: {
                              action: 'add_scl_imp_user_onboarding',
                              nonce : onboarding_object.nonce,
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
                  $('input#' + courseID + '+ .plus-checkbox').attr( "title" ,"select");
                      $.ajax({
                          type: 'POST',
                          url: onboarding_object.ajax_url,
                          data: {
                              action: 'remove_scl_imp_user_onboarding', 
                              nonce : onboarding_object.nonce,
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
                let youHaveSelected = currentSelectionQuantity + uniqueResouceArray.length;
                let canEnroll = resourceLimitQuantity - currentSelectionQuantity;
                if(currentSelectionQuantity < 1){ 
                    enrollQuantity.innerHTML = uniqueResouceArray.length;
                    currentSelection.innerHTML = uniqueResouceArray.length;
                    courseToGo.innerHTML = resourceLimitQuantity - uniqueResouceArray.length;
                }  else {     
                    enrollQuantity.innerHTML = youHaveSelected;
                    currentSelection.innerHTML = youHaveSelected;
                    courseToGo.innerHTML = canEnroll - uniqueResouceArray.length;   
                }   
                if(canEnroll - uniqueResouceArray.length == 0){
                    $('#add_to_library').attr('disabled', 'disabled');
                    $('#completeButton').fadeOut(500);
                    $('#completeButton').fadeIn(500);
                    $('#completeButton').fadeOut(500);
                    $('#completeButton').fadeIn(500);
                    $('.instruct').text('Complete')
                  } else {
                    $('#add_to_library').removeAttr('disabled');
                    $('.instruct').text('Add to Library')
                }
        });
    }
  
     // enroll user to the selected course when they click on Add to Library
     $('#add_to_library').click(function(){
      $.ajax({
              type: 'POST',
              url: onboarding_object.ajax_url,
              data: {
                  action: 'enroll_user_from_onboarding_page', 
                  nonce : onboarding_object.nonce,
                  course_array: uniqueResouceArray, 
              },
              success: function(response) {
                  if(response) {
                      location.reload();
                      console.log('course_enrolled');
                  }
              },
          });
      })
  
      // When they click on complete user meta data will be changed
      // and they will not able to come back to this page again
      $('#completeButton').click(function(){
          $.ajax({
              type: 'POST',
              url: onboarding_object.ajax_url,
              data: {
                  action: 'add_meta_value_on_complete', 
                  nonce : onboarding_object.nonce,
                  course_array: uniqueResouceArray, 
              },
              success: function(response) {
                  if(response) {
                      location.href = '/dashboard';
                  }
              },
          });
      })
  
  
      // load preseleted course, so they dont loss their pre selected course from onboarding
      $.ajax({
          type: 'GET',
          url: onboarding_object.ajax_url,
          data: {
              action: 'preselected_course_ids', 
              nonce : onboarding_object.nonce,
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
  
  });