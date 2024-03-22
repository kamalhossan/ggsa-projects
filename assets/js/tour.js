jQuery(document).ready(function($){

    $('#tour-popup').click(()=>{
        $('#tourStart').modal('show');
    })

    // check has class in body tag
    if($('.tour_status').hasClass('start-tour')){
        // $('#tour-popup').trigger('click');
        $('#tourStart').modal('show');
    }

    // for professional learning
     $('.ld-lesson-item-expanded').css('maxHeight','100%');
     imgUrl = tour_object.home_url + '/assets/img/assessment.jpg';
     newElementforTou = '<div class="tour-assestment-img">';
     newElementforTou += '<img src="'+imgUrl+'" alt="">';
     newElementforTou += '</div>';
     $('.ld-tabs-content').after(newElementforTou);
     $('.tour-assestment-img').hide();
             
    // we are not using title on the popup's that'why we are not using title
    // and I hide title field on the popup's by hidden popup title with !important

    // Add all steps for My School Box (Dashboard) Page
    mySchoolBoxSteps = [
        {
            content: "This is your member profile. Click the three dots to view and make minor profile changes or log out.",
            // title: "Welcome aboard 👋",
            target: ".user-info",
            order: 1,
            group: 'my-school-box',
        },
        {
            content: "Use the side menu to navigate to other useful pages on the platform.",
            // title: "Welcome aboard 👋",
            target: ".nav-menu",
            order: 2,
            group: 'my-school-box',
        },
        {
            content: "Click on My School Box to get an overview of everything our platform has to offer you.",
            // title: "My School Box",
            target: ".my-school-box",
            order: 3,
            group: 'my-school-box',
        },
        {
            content: "Search for and explore hundreds of resources to improve your teaching via the GGSA Product Range page.",
            // title: "My School Box",
            target: ".ggsa-product-range",
            order: 4,
            group: 'my-school-box',
        },
        {
            content: "Click on Our School to connect with fellow educators in your school using the School Forum. Keep track of your collective progress through the Team Learning Plan and School Professional Learning Report.",
            // title: "My School Box",
            target: ".our-school",
            order: 5,
            group: 'my-school-box',            
            afterEnter: async () => {
                    // return new Promise(async (resolve) => {  
                    // await tg.updatePositions()
                    // return resolve(true)
                    // })
                    console.log('has sub menu implement when page is ready');
                }
        },
        {
            content: "View, manage and search through your personal library of selected resources in My Library",
            // title: "My School Box",
            target: ".my-library",
            order: 6,
            group: 'my-school-box',
        },
        {
            content: "Track your learning progress through your individual Learning Pathway, Learning Plan and Professional Learning Report.",
            // title: "My School Box",
            target: ".my-learning",
            order: 7,
            group: 'my-school-box',
        },
        {
            content: "Start a discussion with your peers or get expert support from our team for the units and modules you are enrolled in.",
            // title: "My School Box",
            target: ".our-forum",
            order: 8,
            group: 'my-school-box',
        },
        {
            content: "View and manage your information and your school information in My Profile.",
            // title: "My School Box",
            target: ".my-profile",
            order: 9,
            group: 'my-school-box',
        },
        {
            content: "Use the referral form to bring your colleagues to the GGSA platform and unlock more free resources for you.",
            // title: "My School Box",
            target: ".grow-school-network",
            order: 10,
            group: 'my-school-box',
        },
        {
            content: "Share the GGSA platform with your principal so they can sign your school up for a School Resource Partnership and unlock unlimited access to all our resources.",
            // title: "My School Box",
            target: ".imp-school-results",
            order: 11,
            group: 'my-school-box',
        },
        {
            content: "Find the support you need while navigating the platform by sending us an email with your question.",
            // title: "My School Box",
            target: ".support-call",
            order: 12,
            group: 'my-school-box',
        },
        {
            content: "You will receive notifications for all your interactions with the platform as well as when someone from your school signs up to GGSA.",
            // title: "My School Box",
            target: ".relative.flex.items-center.justify-center.w-10.h-10.bg-white.rounded-full",
            order: 13,
            group: 'my-school-box',
        },
        {
            content: "Customise your view of My School Box with your school logo and images from your school.",
            // title: "My School Box",
            target: ".school_logo",
            order: 14,
            group: 'my-school-box',
        },
        {
            content: "Track your progress towards achieving your goals with scores for each module you are enrolled in.",
            // title: "My School Box",
            target: ".my-professional-record-section",
            order: 15,
            group: 'my-school-box',
        },
        {
            content: "View and navigate to your  Curriculum programs, Professional Learning modules or School Improvement tools.",
            // title: "My School Box",
            target: ".my-library-section",
            order: 16,
            group: 'my-school-box',
        },
        {
            content: "Catch up with what fellow educators are doing on the platform.",
            // title: "My School Box",
            target: ".our-school-section",
            order: 17,
            group: 'my-school-box',
        },
        {
            content: "Discover the latest news on the GGSA blog.",
            // title: "My School Box",
            target: ".news-section",
            order: 18,
            group: 'my-school-box',
        },
        {
            content: "Learn about the progress schools across the country the making by implementing the GGSA programs.",
            // title: "My School Box",
            target: ".share-school-section", 
            order: 18,
            group: 'my-school-box',
        },
        {
            content: "Learn the three main categories of GGSA products. Navigate to a category you’re interested in or view and search through all available resources by clicking “Access to more GGSA resources”.",
            // title: "My School Box",
            target: ".access-resources", 
            order: 19,
            group: 'my-school-box',
        },
        {
            content: "Receive personalised suggestions for units based on the Curriculum resources already in your Library or discover and engage with popular choices on the platform.",
            // title: "My School Box",
            target: ".section-recommend", 
            order: 20,
            group: 'my-school-box',
        },  
        // {
        //     content: "Explore personalised recommendations for modules based on the Professional Learning resources already in your Library or discover and engage with popular choices on the platform.",
        //     // title: "My School Box",
        //     target: ".popular-modules", 
        //     order: 21,
        //     group: 'my-school-box',
        // },
    ];

    // add all steps gor GGSA Product Range Page
    ggsaProductRange = [
        {
            content: "Find all our Curriculum, Professional Learning and School Improvement resources. Begin typing to see search suggestions.",
            // title: "Welcome aboard 👋",
            target: ".ss-search",
            order: 1,
            group: 'ggsa-product-range',
        },
        {
            content: "Access all GGSA Curriculum Units categorised by Subject.",
            target: "#curriculum-tab",
            order: 2,
            group: 'ggsa-product-range',
        },
        {
            content: "Access all GGSA Curriculum Units categorised by Subject.",
            target: ".second-level",
            order: 3,
            group: 'ggsa-product-range',
        },
        {
            content: "Click “About” to learn more about the resources we provide for each subject, and use the search function to browse through all the available resources in a subject category.",
            target: "#childhood .mt-3.overflow-hidden",
            order: 4,
            group: 'ggsa-product-range',
        },
        {
            content: "Click “View Details” to learn more about each specific unit within a year level. Add more units to your library by ticking the boxes on their left.<br>Click Resources to learn more about the resources available in each unit. View samples of Lesson 1, 2 and a Teaching Guide.",
            target: ".guugu-yimithirr-playschool",
            order: 5,
            group: 'ggsa-product-range',
        },
        {
            content: 'Once you’re finished selecting your resources, click “Add to Library”.',
            target: ".progress-status",
            order: 6,
            group: 'ggsa-product-range',
        },
        {
            content: 'View all the resources you’ve added from across Curriculum, Professional Learning and School Improvement. Once a unit or module is added you will see it appear here and in My Library.',
            target: ".library-container",
            order: 7,
            group: 'ggsa-product-range',
        },
    ];

    myLibraryPage = [
        {
            content: "Search through your selected Curriculum, Professional Learning and School Improvement resources. Begin typing to see search suggestions.",
            // title: "Welcome aboard 👋",
            target: ".ss-search", 
            order: 1,
            group: 'my-library-page',
        },
        {
            content: "Once you have selected Curriculum units from the GGSA Product Range they will appear here. Start using one of your units by clicking on the card with its name and cover image.",
            target: "[data-tab-key='#curriculum']", 
            order: 2,
            group: 'my-library-page',
        },
        {
            content: "Once you have selected Professional Learning modules from the GGSA Product Range, they will appear here. Start using modules by clicking on the card with its name and cover image.",
            target: "[data-tab-key='#professional-learning']", 
            order: 3,
            group: 'my-library-page',
        },
        {
            content: "Use “Download Unit” to download all the resources within a unit to your computer.",
            target: "[data-tab-key='#school-improvement']", 
            order: 4,
            group: 'my-library-page',
        },
        {
            content: "Click “Start” when you are ready to begin test. Use the “Back” and “Next” buttons to navigate the questions. Click “Submit” to receive your score. If you don’t pass you can retake your test and review your answers.",
            target: "[data-tab-key='#school-improvement']", 
            order: 4,
            group: 'my-library-page',
        },
    ];

    topicsStep = [
        {
            content: "Use “Download Unit” to download all the resources within a unit to your computer.",
            target: "a#topic-download", 
            order: 1,
            group: 'topics-step',
        },
        {
            content: "Browse through all the lessons and other resources within the unit. Click on a lesson or resource to view its content and start teaching!",
            target: ".ld-lesson-navigation", 
            order: 2,
            group: 'topics-step',
        },
        {
            content: "Download any lesson by clicking the download button next to its name.",
            target: "a#topic-download", 
            order: 3,
            group: 'topics-step',
        },
        {
            content: "Track your progress towards the completion of a particular lesson. Completed lessons are marked with a green tick in the lesson list on the left.",
            target: ".ld-topic-status", 
            order: 4,
            group: 'topics-step',
        },
        {
            content: "Move between lessons in a unit by using the buttons “Previous Lesson” and “Next Lesson”.",
            target: ".ld-content-actions", 
            order: 5,
            group: 'topics-step',
        },
        {
            content: "Share your positive experience with a lesson or report a problem.",
            target: ".lesson-bottom", 
            order: 6,
            group: 'topics-step',
        },
        {
            content: "Use the Forum and Ratings and Reviews tabs to discuss units with fellow educators, receive expert support, or view and contribute to unit ratings and reviews.",
            target: "#topic-bottom", 
            order: 7,
            group: 'topics-step',
        },
        {
            content: "Click the arrow next to the unit’s name to go back to your list of resources in My Library.",
            target: "button.entry-goback-form-button-sumbit", 
            order: 8,
            group: 'topics-step',
        },
    ]

    professionalLearning = [
        {
            content: "Browse through all the resources within a particular module. Click on a resource to view its content and start learning..",
            target: ".ld-lesson-item-expanded", 
            order: 1,
            group: 'professional-learning',
            beforeEnter: async () => {
                // return new Promise(async (resolve) => {  
                // await tg.updatePositions()
                // return resolve(true)
                // })
                // if has class 
            }
        },
        {
            content: "Once you are done with a resource, move to the next one or go back. Mark a resource as complete and progress to more challenging material.",
            target: ".ld-content-actions", 
            order: 2,
            group: 'professional-learning',
        },
        {
            content: "Track your progress towards completion of a resource. Completed lessons are marked with a green tick in the resources list on the left.",
            target: ".ld-topic-status", 
            order: 3,
            group: 'professional-learning',
        },
        {
            content: "During a lesson, you may be asked to Check Your Understanding of the content through a test. To complete a lesson take the Test Your Understanding.",
            target: ".ld-lesson-navigation .ld-table-list-item-wrapper", 
            order: 4,
            group: 'professional-learning',
        },
        {
            content: "Click “Start” when you are ready to begin test. Use the “Back” and “Next” buttons to navigate the questions. Click “Submit” to receive your score. If you don’t pass you can retake your test and review your answers.", 
            target: '.tour-assestment-img',
            order: 5,
            group: 'professional-learning',
        },
    ]

    const tg = new tourguide.TourGuideClient({
        showStepProgress: false,
        showStepDots: false,
        exitOnClickOutside: false,
        prevLabel: "Skip Tour",
        // nextLabel: "Forwards",
        hidePrev: false,
        closeButton: false,
        
    });

    tg.addSteps(mySchoolBoxSteps);
    tg.addSteps(ggsaProductRange);
    tg.addSteps(myLibraryPage);
    tg.addSteps(topicsStep);
    tg.addSteps(professionalLearning);

    function customizations(){
        $('body').append('<div class="tour-backdrop"></div>');
        $('.tg-dialog-btn').removeClass('disabled');
        $('.tg-dialog-btn').removeAttr('disabled');
        $('#tg-dialog-prev-btn').click(()=>{
            tg.exit();
        })
    }

    $('#start-tour.dashboard').click(function(){
        tg.start('my-school-box').then(()=>{
            customizations();
        });
        
    });

    $('#start-tour.resources').click(function(){
        tg.start('ggsa-product-range').then(()=>{
            customizations();
        });;
    });

    $('#start-tour.myLibrary').click(function(){
        tg.start('my-library-page').then(()=>{
            customizations();
        });;
    });

    $('#start-tour.topics').click(function(){
        tg.start('topics-step').then(()=>{
            customizations();
        });;
    });



    $('#start-tour.learning').click(function(){
        tg.start('professional-learning').then(()=>{
            $('.ld-tabs-content').hide();
            $('.tour-assestment-img').show();
            customizations();

        });;
    });

    function hideExtraElementforTour(){
        $('.ld-tabs-content').show();
        $('.tour-assestment-img').hide();
    }

    $('#skip-tour.dashboard').click(()=>{
        completeMeta();
    });
    $('#skip-tour.learning').click(()=>{
        tg.exit();
        completeMeta();
        hideExtraElementforTour();
    });

    $('#skip-tour.resources').click(()=>{
        completeMeta();
    });

    $('#skip-tour.myLibrary').click(()=>{
        completeMeta();
    });
    $('#skip-tour.topics').click(()=>{
        completeMeta();
    });

    tg.onAfterExit(()=>{
        hideExtraElementforTour();
        $('.tour-backdrop').remove();
    })
        
    tg.onFinish(()=>{
        hideExtraElementforTour();
        completeMeta();
    }) 
    
    function completeMeta(){
        // remove append tour-backdrop div
        $('.tour-backdrop').remove();
        // write a jqeury ajax function to handle wordpress function
        $.ajax({
            url: tour_object.ajax_url,
            type: 'POST',
            data: {
                action: 'ggsa_set_tour_complete',
                page_name: tour_object.page_name,
            },
            success: function(response) {
                // Handle the response from the server
                console.log(response);
            },
        });
    }

    tg.onAfterStepChange(()=>{
        $('.tg-dialog-btn').removeClass('disabled');
        $('.tg-dialog-btn').removeAttr('disabled');
        $('#tg-dialog-prev-btn').click(()=>{
            tg.exit();
        })
    })

    
})

