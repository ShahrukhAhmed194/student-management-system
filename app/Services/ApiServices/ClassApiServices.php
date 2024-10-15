<?php
namespace App\Services\ApiServices;

use Illuminate\Support\Facades\DB;

class ClassApiServices{

    public function getTrackOneDetails(){
        $track = [
            "banner" => "https://da.com.bd/track-1.png",
            "details" => [
                "title" => "Little Programmer",
                "info" => "The Little Programmer program is designed for children aged 7 to 8 years to enlighten them with coding skills through visual programming languages. The program's curriculum is created to develop their coding fundamental, math, and design skills. Our program will help children to improve their imagination and creativity through coding concepts.",
                "duration" => "9 months"
            ],
            "levels" => [
                [
                    "level_title" => "ScratchJr",
                    "level_details" => "ScratchJr is a block based programming language. It is a type of visual programming language that is suitable for 7-8 yrs old children. By dragging and dropping visual blocks children will get to learn about important coding fundamental concepts such as sequence, conditionals etc and will be able to design their own interactive stories and games.",
                    "level_final_outcome" => "Coding Fundamentals (Basics)",
                    "level_duration" => "4 Months",
                    "image_link" => "https://dreamersacademy.com.bd/assets_2/img/section/banner1.png"
                ],
                [
                    "level_title" => "Scratch",
                    "level_details" => "Scratch is a block based programming language design for children aged 8+ years. It uses visual programming blocks for coding. It is an advanced version of ScratchJr which includes a lot of programming concepts. Children use these blocks to learn fundamental coding concepts, math concepts, algorithmic thinking, computational thinking, and creativity. They will design games, and animated stories using Scratch.",
                    "level_final_outcome" => "Coding Fundamentals (Basics)",
                    "level_duration" => "4 Months",
                    "image_link" => "https://dreamersacademy.com.bd/assets_2/img/section/banner1.png"
                ],
                [
                    "level_title" => "Wix",
                    "level_details" => "Wix is a block based website designer. It is one of the most popular website designer out there. Children will get to learn about the concept of the internet, websites and how it's designed. The fundamental concepts of website design will be covered. Finally, they will design their own personal website as the final project.",
                    "level_final_outcome" => "Website Design Fundamentals (Basics)",
                    "level_duration" => "1 Month",
                    "image_link" => "https://dreamersacademy.com.bd/assets_2/img/section/banner1.png"
                ]
            ]
        ];
    
        return $track;
    }

    public function getTrackTwoDetails(){
        $track = [
            "banner" => "https://da.com.bd/track-2.png",
            "details" => [
                "title" => "Junior Programmer",
                "info" => "Our Junior coders program provides a variety of different coding skills for school-going students ages 9 to 10 to meet the varied educational needs of every student. It's an excellent idea to enroll in elective courses such as advanced Scratch, HTML, CSS, and Mobile Application development. Our unique learning platform allows them to create their own websites, animations, design, and development.",
                "duration" => "10 months"
            ],
            "levels" => [
                [
                    "level_title" => "Scratch",
                    "level_details" => "Scratch is a programming language designed for children aged 8+ years. It uses visual blocks to teach coding to young children. It is an advanced version of ScratchJr which includes a lot of programming concepts. Learning the programming basics of Scratch online programming will launch the implementation of coding in the project. Children use Scratch-based block programming to develop math concepts, algorithmic thinking, computational thinking, and creativity.",
                    "level_final_outcome" => "Coding Fundamentals (Basics)",
                    "level_duration" => "4 Months",
                    "image_link" => "https://dreamersacademy.com.bd/assets_2/img/section/banner2.png"
                ],
                [
                    "level_title" => "Mobile App Development",
                    "level_details" => "Mobile App development is great for children because apps are a big part of their everyday lives. Building Android apps is a great way to see how the tools work we use every day. In these classes, we provide a fantastic way to observe how the gadgets and programs work by building android applications. MIT App Inventor is a block based mobile app development language. Using visual blocks children will be able to design and develop native mobile apps.",
                    "level_final_outcome" => "Mobile Application Development (Basics)",
                    "level_duration" => "4 Months",
                    "image_link" => "https://dreamersacademy.com.bd/assets_2/img/section/banner2.png"
                ],
                [
                    "level_title" => "HTML and CSS",
                    "level_details" => "HTML and CSS are used to design all the website on the internet. As a young coder the skill of designing website using HTML and CSS is a big plus. Kids of different ages can work with HTML and CSS codes to become excellent web programmers. As a final project they will be designing their very own personal website and upload them in a server.",
                    "level_final_outcome" => "Website Design Fundamentals (Basics)",
                    "level_duration" => "2 Months",
                    "image_link" => "https://dreamersacademy.com.bd/assets_2/img/section/banner2.png"
                ]
            ]
        ];

        return $track;
    }

    public function getTrackThreeDetails(){
        $track = [
            "banner" => "https://da.com.bd/track-3.png",
            "details" => [
                "title" => "Programmer",
                "info" => "In this age of technology, we strongly believe that learning how to code is the best skill a teen can develop to learn programming languages. Being a teen from 11-14 years of age can be a remarkable time to learn the fundamentals of front-end design, Python, HTML, CSS, Javascript, and Robotics. This course is appropriate for teens who want to take their primary programming skills one step further.",
                "duration" => "10 months"
            ],
            "levels" => [
                [
                    "level_title" => "Python Programming",
                    "level_details" => "Python is a high-level, interpreted, general-purpose programming language. It is currently one of the most popular programming languages in the world. Our coders will learn all the necessary coding fundamentals using this high-level language.",
                    "level_final_outcome" => "Coding Fundamentals (Basics)",
                    "level_duration" => "3 Months",
                    "image_link" => "https://dreamersacademy.com.bd/assets_2/img/section/banner3.png"
                ],
                [
                    "level_title" => "Website Design",
                    "level_details" => "Whenever you are a web programmer, you will learn and understand the necessity of HTML and CSS. Kids of different ages can work with HTML and CSS codes to become excellent web programmers. They are going to get the benefit of knowing the fundamentals of HTML and CSS to design a website. Apart from HTML and CSS there is one othe technology that is used in designing interactive websites and that is Javascript. Our coders will learn all the fundamental concepts of the Javascript programming language. Apart from this, they will also learn about a front end design framework using which they will be able to design beautiful, interactive and responsive websites.",
                    "level_final_outcome" => "Website Design",
                    "level_duration" => "4 Months",
                    "image_link" => "https://dreamersacademy.com.bd/assets_2/img/section/banner3.png"
                ],
                [
                    "level_title" => "Robotics & IOT",
                    "level_details" => "Internet of Things (IOT) refers to objects/things that are connected to each other and communicate with each other via the internet. This is a future-tech which we believe the current generation of innovators should learn. In this level they will build IOT devices as well as fully functional robots.",
                    "level_final_outcome" => "Hardware and Software Integration",
                    "level_duration" => "3 Months",
                    "image_link" => "https://dreamersacademy.com.bd/assets_2/img/section/banner3.png"
                ]
            ]
        ];

        return $track;
    }

    public function getClassDetails($user_id){
        $reformed_data = array();
        $classes = DB::select("SELECT pnt.points, cls.name as class_name, sch.time, cs.session_date, cs.session_started, cs.session_ended, cs.recording_link,sa.status as attendance, p.name as project_title, p.learning_outcomes, sp.project_status, sp.project_assesment, sp.comments
                FROM students std
                LEFT JOIN student_reward_points pnt ON (std.id = pnt.student_id)
                JOIN da_classes cls ON (cls.id = std.class_id)
                JOIN class_schedules sch ON (sch.class_id = cls.id)
                JOIN class_sessions cs ON (cs.class_id = cls.id)
                LEFT JOIN student_projects sp ON (sp.class_id = cls.id)
                JOIN student_attendances sa ON (sa.student_id = std.user_id)
                LEFT JOIN projects p ON (p.id = sp.project_id)
                WHERE std.user_id = $user_id ");

        if($classes && $classes != '[]'){
            foreach($classes as $index => $class){
                $reformed_data[$index] = [
                    "class_name" => $class->class_name,
                    "date" => $class->session_date,
                    "time" => $class->time,
                    "class_recording_link" => $class->recording_link,
                    "attendance" => $class->attendance,
                    "class_start_time" => $class->session_started,
                    "class_end_time" => $class->session_ended,
                    "total_points" => $class->points,
                    "projects" => [
                        "thumbnail" => "https://da.com.bd/track-1.png",
                        "project_title" => $class->project_title,
                        "learning_outcomes" => $class->learning_outcomes,
                        "status" => $class->project_status,
                        "assessment" => $class->project_assesment,
                        "notes" => $class->comments
                    ],
                ];
            }
        }
        
        return $reformed_data;
    }

}