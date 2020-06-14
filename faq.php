<?php
require 'init.php';

class question {
    public function __construct($q,$a)
    {
        $this->q = $q;
        $this->a = $a;
    }

    public $q;
    public $a;
}

$questions = array();
array_push($questions,new question(
        "What is the application process for my child/student to apply for the Percussion Scholarship Program?",
    "Each spring, the Chicago Symphony Orchestra (CSO) sends Application Packets and email alerts to third and fourth grade teachers at elementary schools in Chicago, both public and private. Teachers are asked to nominate outstanding students. Teachers fill out a questionnaire, and distribute applications to the students they have nominated. Nominated students and their parents complete the application, which is then sent to the program’s directors.

If completed application materials from teachers and students are received by the printed deadline, the students and their families will then be invited to attend the Percussion Scholarship Groups spring recital at Symphony Center. Applicants must attend the recital. After hearing the performance and learning more about the experience of playing in the group, applicants are invited to sign up for a brief interview scheduled for the following weekend. At the interview, the program’s directors meet with each prospective student and their parents. They are given some simple rhythmic exercises which test for aptitude.

All applicants are notified as to whether or not they have been accepted for a provisional training period. Those accepted begin individual and group lessons during the summer months. A preliminary performance at the end of the summer allows the program’s directors to determine which students will continue and which will conclude their participation."));
array_push($questions,new question("How do I know if teachers at my school received Application Packets?","The CSO sends to a long list of schools, but it may not be comprehensive. If you would like to see if you your child/student’s school is included, please e-mail institute@cso.org. We will be happy to add schools to the list, as long as they are within Chicago city limits.

An application may be also downloaded from this site in April."));
array_push($questions,new question("Who is eligible to apply?","Students who are in the third or fourth grade attending a school in the Chicago city limits."));
array_push($questions,new question("Who is not eligible to apply?","The PSP is not open to students or families who are affiliated with the CSO or the CSOA or who do not live in the city of Chicago or attend a school within the city limits of Chicago."));
array_push($questions,new question("If accepted into the program, what is the time commitment?","The Percussion Scholarship Group meets weekly on Saturdays (and sometimes on Sundays) year round, with the exception of weekends that coincide with major holidays like Thanksgiving or Christmas. Additionally, students are asked to practice for a minimum of 45 minutes daily at their own homes, and practice time increases as student’s progress in the program."));
array_push($questions,new question("How long can my child/student participate in the program?","Students who are invited to continue after the provisional period are eligible to participate through the eighth grade, and select students are invited to continue through high school."));
array_push($questions,new question("How many new spots are there each season for new participants?","It varies year to year, based on the total number of current participants. There is room for approximate 5 to 10 new students (provisionally) each spring."));
array_push($questions,new question("Are there any costs associated with participation in the program?","No. The program allows participants to study with a member of the Chicago Symphony Orchestra percussion section free of charge. Instruments are provided for home practice as well as for individual and group lessons."));
array_push($questions,new question("How often does the group perform?","The Percussion Scholarship Group performs several times each season at Symphony Center, and occasionally at other venues."));
array_push($questions,new question("My child/student has no prior musical experience. Will he/she still be considered for the program?","Yes. We look to teachers to help identify students who work well with others and have a great sense of responsibility and commitment. Equally importantly, for students to succeed in the program they must have extremely supportive, dependable parents and a strong sense of self-discipline. Prior musical training does not help – or hurt – an applicant’s chances of acceptance into the program."));
array_push($questions,new question("My child/student has been playing percussion for a few years now. Can he/she join?","If the child/student meets the eligibility requirement (in grade 3 or 4 at time of application, and attending a school within Chicago city limits), then they are welcome to apply. Students in higher grades are not eligible to join the program. As previously stated, prior musical training does not help – or hurt – an applicant’s chances of acceptance into the program."));
array_push($questions,new question("My family has summer vacation plans. If accepted into the program, can my child still participate?","This is determined on a case by case basis. It is worth applying for the program, and if accepted, parents should proactively communicate vacation time to the program’s directors. If the child will miss a substantial (2 or more) number of lessons, it can be detrimental to their development and ultimate success in the program."));
array_push($questions,new question("I’m interested in seeing the Percussion Scholarship Group perform. How can I find out about upcoming performances?","Information about upcoming performances can be found on this website: www.percussionscholars.com and on the CSO website, www.cso.org."));


echo $twig->render('faq.twig',["questions"=>$questions,"current"=>"faq"]);


