<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $birthdate = $_POST["birthdate"];
    $fullname = $_POST["fullname"];
    // Calculate Numerology Core Numbers
    $lifePathNumberData = calculateLifePathNumber($birthdate);
    $expressionNumberData = calculateExpressionNumber($fullname);
    $soulUrgeNumberData = calculateSoulUrgeNumber($fullname);
    $birthdayNumberData = calculateBirthdayNumber($birthdate);
    $personalityNumberData = calculatePersonalityNumber($fullname);
    $maturityNumberData = calculateMaturityNumber($birthdate, $fullname);

    echo "<h1>$fullname $birthdate </h1>";

    // Your Life Path Number is: 
    //-----------------------------------
    $lp = "Life paths in numerology represent the journey of your life, outlining your abilities, 
    challenges, and lessons. Calculated from your birthdate, it's like a blueprint for your destiny";
    $lp =  str_replace(".", ".<br>",$lp); # newline on "."
    $lpn = $lifePathNumberData['number'];
    $lpc = $lifePathNumberData['calculation'];
    $lpgood = getLifePathKeywords($lifePathNumberData['number'])['pro'];
    $lpbad = getLifePathKeywords($lifePathNumberData['number'])['con'];
    $lpdes = getLifePathKeywords($lifePathNumberData['number'])['des'];
    echo "<h2>Life Path Number: $lpn</h2>";
    echo "<h5>$lp</h5>";
    #echo "<h3> Your Life Path Number is: <b>$lpn</b> </h3>";
    echo "<h5>You're naturally Tend to be more <b>$lpgood</b> , But Also  <b>$lpbad</b> try to give more focus on that areas!.</h5>";
//    $arry = explode(",",$lpgood);
//    foreach ($arry as $value) {
//        echo "<h5>$value</h5>";
//    }
//    $arry = explode(",",$lpbad);
//    foreach ($arry as $value) {
//        echo "<h5>$value</h5>";
//    }
    $lpdes=  str_replace(".", ".<br>",$lpdes); # newline on "."
    echo "<h5>$lpdes</h5>";

    // Your Expression/Destiny  Number is: 
    $d = "Your Expression Number, from your birth name, reveals your natural talents. It shows what you excel at, 
    highlights areas for improvement, and guides you on using these skills to achieve your life's purpose";
    $d=  str_replace(".", ".<br>",$d); # newline on "."
    $dn = $expressionNumberData['number'];
    $dnc = $expressionNumberData['calculation'];
    $destiny_arry =  getExpressionKeywords($dn);
    $dgood = $destiny_arry['positiveTraits'];
    $dbad = $destiny_arry['negativeTraits'];
    $ddesc = $destiny_arry['description'];
    $dprofessions = $destiny_arry['professions'];

    echo "<h2>Expression/Destiny Number: $dn</h2>";
    echo "<h5>$d</h5>";
    echo "<h4>Your NaturallySkills:</h4>";
    $arry = explode(",",$dgood);
    foreach ($arry as $value) {
        echo "<h5>$value</h5>";
    }
    echo "<h4>Naturally Struggle with! :</h4>";
    $arry = explode(",",$dbad);
    foreach ($arry as $value) {
        echo "<h5>$value</h5>";
    }
    echo  "<h4>Professions that fit your skills! focusing at $ddesc</h4>";
    $arry = explode(",",$dprofessions);
    foreach ($arry as $value) {
        echo "<h5>$value</h5>";
    }

    // Your Soul Urge/Heart's Desire Number is: 
    $su = "Soul Urge Number (Heart's Desire Number): Reveals your deepest desires and motivations .Basically, what fertilize do you need to grow what Can you give me motivation";
    $su = str_replace(".", ".<br>",$su); # newline on "."
    $sun = $soulUrgeNumberData['number'];
    $suc = $soulUrgeNumberData['calculation'];
    $soulurge_arry =  getSoulUrgeKeywords($sun);
    $sumo = $soulurge_arry['motivations'];
    $sudmo = $soulurge_arry['demotivations'];
    $msuggestions = $soulurge_arry['suggestions'];

    echo "<h2>Soul Urge Number (Heart's Desire Number): $sun </h2>";
    echo "<h5>$su</h5>";
    echo "<h4> What Motivte You:</h4>";
    $arry = explode(",",$sumo);
    foreach ($arry as $value) {
        echo "<h5>$value</h5>";
    }
    echo "<h4> What Un-Motivte You:</h4>";
    $arry = explode(",",$sudmo);
    foreach ($arry as $value) {
        echo "<h5>$value</h5>";
    }
    echo "<h3>Actions to Ignite Your Inner Powers For FULL Motivation:</h3>";
    $br_text = str_replace(".", ".<br>", $msuggestions);
    echo "<h5>$br_text</h5>";

    //Your Birthday Number is
    $bddec = "Birth Day Number: It's simply your birth day and provides insight into your innate talents.";
    $bdn = $birthdayNumberData['number'];
    $bdc = $birthdayNumberData['calculation'];
    $bngood = getBirthDayKeywords($birthdayNumberData['number']);

    //Your Personality Number is
    $ps= "Personality Number: 
    It's derived from the consonants in your full birth name and reveals your external self
     or what you're comfortable sharing with others";
    $psn = $personalityNumberData['number'];
    $psnc = $personalityNumberData['calculation'];
    $psngood = getPersonalityKeywords($personalityNumberData['number']);

    echo "<h2>Personality Number: $psn </h2>";
    echo "<h5>$ps</h5>";
    echo "<h3> your public persona, How other see you:</h3>";
    echo  "<h5>$psngood</h5>";

    //Your Maturity Number is: 
    $m = "Maturity Number: It's calculated from both your date of birth and your name.
     It represents the person you will grow into, your true self.";
    $m=  str_replace(".", ".<br>",$m); # newline on "."
    $man = $maturityNumberData['number'];
    $manc = $maturityNumberData['calculation'];
    $mangood = getMaturityKeywords($maturityNumberData['number']);

    echo "<h2>Maturity Number: $man</h2>";
    echo "<h5>$m</h5>";
    echo "<h3> your uture self, revealing your genuine potential:</h3>";
    echo  "<h5>$mangood</h5>";
}
#Procs

// Function to calculate the Numerology Number (reduce to a single digit)
function calculateNumerologyNumber($number)
{
    while ($number > 9) {
        $number = array_sum(str_split((string)$number));
    }
    return $number;
}

// Function to calculate the Life Path Number
function calculateLifePathNumber($birthdate)
{
    $dateParts = explode('-', $birthdate);  // assuming birthdate is in 'Y-m-d' format
    $year = array_sum(str_split($dateParts[0]));
    $month = array_sum(str_split($dateParts[1]));
    $day = array_sum(str_split($dateParts[2]));

    $calculation = '(' . $dateParts[0] . ')' . $year . ' + (' . $dateParts[1] . ')' . $month . ' + (' . $dateParts[2] . ')' . $day;

    $lifepath = calculateNumerologyNumber($year) + $month + $day;
    // Check for Master Numbers 11 and 22, and possibly 33
    if ($lifepath == 11 || $lifepath == 22 || $lifepath == 33) {
        return array('number' => $lifepath, 'calculation' => $calculation);
    }

    // If not a Master Number, reduce to a single digit
    while ($lifepath > 9) {
        $lifepath = array_sum(str_split((string)$lifepath));
    }
    return array('number' => $lifepath, 'calculation' => $calculation);
}

// Function to calculate the Expression Number
function calculateExpressionNumber($fullname)
{
    $letters = str_split(str_replace(' ', '', strtolower($fullname)));

    $sum = 0;
    $calculation = "";
    foreach ($letters as $letter) {
        $value = ord($letter) - 96; // subtract 96 to get the position of the letter in the alphabet
        $sum += $value;
        $calculation .= '(' . $letter . ')' . $value . ' + ';
    }

    // Remove the last ' + ' from the calculation string
    $calculation = substr($calculation, 0, -3);

    while ($sum > 9) {
        $sum = array_sum(str_split($sum));
    }

    return array('number' => $sum, 'calculation' => $calculation);
}


// Function to calculate the Soul Urge Number
function calculateSoulUrgeNumber($fullname)
{
    // Map of vowels to their numerological equivalents
    $vowel_map = [
        'a' => 1,
        'e' => 5,
        'i' => 9,
        'o' => 6,
        'u' => 3,
        'y' => 7
    ];
    $total = 0;
    $calculation = "";
    $name = strtolower($fullname);
    for ($i = 0; $i < strlen($name); $i++) {
        // Check if the character is a vowel
        if (isset($vowel_map[$name[$i]])) {
            $value = $vowel_map[$name[$i]];
            $total += $value;
            $calculation .= '(' . $name[$i] . ')' . $value . ' + ';
        }
    }

    // Remove the last ' + ' from the calculation string
    $calculation = substr($calculation, 0, -3);

    // Reduce the total to a single digit, unless it's a master number (11, 22, 33)
    while ($total > 9 && $total != 11 && $total != 22 && $total != 33) {
        $total = array_sum(str_split((string)$total));
    }

    return array('number' => $total, 'calculation' => $calculation);
}


// Function to calculate the Birthday Number
function calculateBirthdayNumber($birthdate)
{
    // check if date is valid
    if (strtotime($birthdate) === false) {
        echo 'Invalid birthdate format. Please use YYYY-MM-DD';
        return;
    }

    // split birthdate into array
    $dateParts = explode('-', $birthdate);
    $day = $dateParts[2];

    return array('number' => calculateNumerologyNumber($day), 'calculation' => '(' . $birthdate . ')' . $day);
}

// Function to calculate the Personality Number
function calculatePersonalityNumber($fullname)
{
    // Map of consonants to their numerological equivalents
    $consonant_map = [
        'b' => 2,
        'c' => 3,
        'd' => 4,
        'f' => 6,
        'g' => 7,
        'h' => 8,
        'j' => 1,
        'k' => 2,
        'l' => 3,
        'm' => 4,
        'n' => 5,
        'p' => 7,
        'q' => 8,
        'r' => 9,
        's' => 1,
        't' => 2,
        'v' => 4,
        'w' => 5,
        'x' => 6,
        'z' => 8
    ];

    $total = 0;
    $name = strtolower($fullname);
    $consonantValues = [];
    for ($i = 0; $i < strlen($name); $i++) {
        // Check if the character is a consonant
        if (isset($consonant_map[$name[$i]])) {
            $consonantValues[] = $name[$i] . "(" . $consonant_map[$name[$i]] . ")";
            $total += $consonant_map[$name[$i]];
        }
    }

    $calculation = implode(" + ", $consonantValues);
    while ($total > 9 && $total != 11 && $total != 22 && $total != 33) {
        $calculation .= " = " . $total;
        $total = array_sum(str_split((string)$total));
    }

    // Final result
    $calculation .= " = " . $total;

    return array('number' => $total, 'calculation' => $calculation);
}


// Function to calculate the Maturity Number
function calculateMaturityNumber($birthdate, $fullname)
{
    $lifePathNumberData = calculateLifePathNumber($birthdate);
    $expressionNumberData = calculateExpressionNumber($fullname);

    $total = $lifePathNumberData['number'] + $expressionNumberData['number'];

    $calculation = $lifePathNumberData['calculation'] . " + " . $expressionNumberData['calculation'] . " = " . $total;

    while ($total > 9 && $total != 11 && $total != 22 && $total != 33) {
        $calculation .= " = " . $total;
        $total = array_sum(str_split((string)$total));
    }

    // Final result
    $calculation .= " = " . $total;

    return array('number' => $total, 'calculation' => $calculation);
}


// Function to get Life Path Number keywords
function getLifePathKeywords($number)
{
    $keywords = [
        1 => "Leader, Free, New Ideas",
        2 => "Team Player, Fair, Calm",
        3 => "Creative, Outspoken, Full of Life",
        4 => "Steady, Down-to-Earth, Never Gives Up",
        5 => "Flexible, Loves Adventure, Exciting",
        6 => "Peaceful, Loves Home, Always Helps",
        7 => "Deep Thinker, Smart, Sees Inside Things",
        8 => "Goal-Oriented, Boss, Gets Things Done",
        9 => "Kind, Gives a Lot, Feels for Others",
        11 => "Has Sixth Sense, Dreams Big, Inspiring",
        22 => "Makes Big Plans Real, Gets Results, Tough",
        33 => "Teaches, Helps Others, Guides"
    ];

    $negatives = [
        1 => "Bossy, Stubborn",
        2 => "Can't Decide, Too Quiet",
        3 => "Messy, Talks Too Much",
        4 => "Too Strict, Thinks Small",
        5 => "Rushes Things, Unpredictable",
        6 => "Worries Too Much, Overprotective",
        7 => "Isolated, Thinks Negative",
        8 => "Materialistic, Too Tough",
        9 => "Can't Forgive, Often Unhappy",
        11 => "Worries, Dreams Too Much",
        22 => "Thinks Too Big, Not Practical",
        33 => "Gives Too Much, Over committed"
    ];

    $descriptions = [
        1 => "If your Life Path number is 1, you are a natural-born leader. You have a strong desire for independence and the need to make your mark on the world. You're likely a creative and innovative individual, always eager to tackle new and exciting challenges. Remember to keep your autonomous nature in check and consider the ideas and feelings of others.",

        2 => "As a Life Path 2, you thrive in partnerships and group settings. You possess an innate ability to foster peace and harmony, making you an essential part of any team. Your calm and diplomatic nature can help resolve conflicts and create a balanced environment. Remember to value your personal needs as much as those of others.",

        3 => "Life Path 3 denotes a person full of imagination and expressiveness. Your energetic nature attracts others and can make you the life of the party. With your creativity, you have the ability to inspire and bring joy to others. Just be careful to focus your energy and not to spread yourself too thin.",

        4 => "If your Life Path number is 4, you are reliable and pragmatic. Your steady and persistent nature helps you achieve your goals. You value stability and practicality, making you the rock in your social and professional circles. Don't forget to take risks and enjoy life's unpredictable moments.",

        5 => "As a Life Path 5, you are an explorer, always seeking adventure and dynamic experiences. Your free spirit and adaptability make you flexible in the face of change. You crave freedom and have a knack for living in the moment. But remember, some level of stability is necessary for long-term success.",

        6 => "If your Life Path number is 6, you are a natural helper. You find peace and joy in providing for others and creating a harmonious environment. Home and family are essential to you. While your nurturing nature is admirable, remember to also take care of yourself.",

        7 => "A Life Path 7 individual is reflective and insightful. You have a deep analytical mind and a natural inclination toward introspection. Your pursuit for knowledge and understanding is a key part of your identity. Be mindful to balance your inward focus with outward engagement with the world around you.",

        8 => "If you're a Life Path 8, you are ambitious and driven. You have a natural talent for leadership and a strong desire for success. Remember, while achieving your goals, it's also essential to maintain ethical standards and not let material success define your happiness.",

        9 => "A Life Path 9 individual is an altruist at heart. You are compassionate and always looking for ways to contribute to the greater good. Your sympathetic nature and desire for completion make you a beacon of light in the lives of others. Just remember, it's also okay to focus on your personal needs and desires.",

        11 => "Life Path 11 individuals are intuitive and visionary. You have a strong sense of inspiration, which can serve as a guiding light for others. Your inspirational nature makes you a beacon of enlightenment. Remember to ground your high aspirations in practical realities.",

        22 => "As a Life Path 22, you are a builder and a dream achiever. Your strong and practical nature can bring ideas to life. You have the potential to achieve great things, but remember to stay grounded and not let your ambitions lead you to impractical ventures.",

        33 => "If your Life Path number is 33, you are an educator and a philanthropist. You have a natural inclination to guide othersand serve humanity. Your role is often that of a teacher, helping others understand the world and themselves. However, remember to also take time for self-care and personal development."
    ];
    return array('pro' => $keywords[$number], 'con' => $negatives[$number], 'des' => $descriptions[$number]);
}

// Function to get Expression Number keywords
function getExpressionKeywords($number)
{
    $positiveTraits = [
        1 => "Leader, Independent, Assertive",
        2 => "Diplomatic, Peaceful, Detail-oriented",
        3 => "Creative, Communicative, Enthusiastic",
        4 => "Practical, Loyal, Hardworking",
        5 => "Adventurous, Energetic, Curious",
        6 => "Nurturing, Responsible, Selfless",
        7 => "Introspective, Analytical, Deep",
        8 => "Ambitious, Organized, Disciplined",
        9 => "Compassionate, Generous, Tolerant",
        11 => "Intuitive, Inspirational, Spiritual",
        22 => "Master Builder, Realistic, Practical",
        33 => "Teacher, Humanitarian, Self-sacrificing"
    ];

    $negativeTraits = [
        1 => "Stubborn, Dominant, Aggressive",
        2 => "Indecisive, Overly Sensitive, Passive",
        3 => "Scattered, Extravagant, Superficial",
        4 => "Stubborn, Narrow-minded, Reclusive",
        5 => "Impulsive, Restless, Non-committal",
        6 => "Worrier, Critical, Unrealistic",
        7 => "Pessimistic, Unsocial, Secretive",
        8 => "Materialistic, Egotistical, Power-hungry",
        9 => "Impersonal, Scattered, Moody",
        11 => "Nervous, Dreamy, Subject to Depression",
        22 => "Nervous, Sensitive, Overly Serious",
        33 => "Overly Sensitive, Emotional, Perfectionist"
    ];

    $descriptions = [
        1 => "great leadership and determination.",
        2 => "diplomacy and consideration for others.",
        3 => "creativity and self-expression.",
        4 => "practicality and careful planning.",
        5 => "adventurous spirit and curiosity.",
        6 => "care and responsibility.",
        7 => "introspection and inner wisdom.",
        8 => "ambition and focus on success.",
        9 => "global awareness and compassion.",
        11 => "A master number with a focus on inspiration and enlightenment.",
        22 => "A master number with a focus on turning dreams into reality.",
        33 => "A master number with a focus on altruism and nurturing."
    ];

    $professions = [
        1 => 'Entrepreneur,Manager,Inventor',
        2 => 'Diplomat,Counselor,Musician',
        3 => 'Writer,Actor,Artist',
        4 => 'Engineer,Architect,Teacher',
        5 => 'Salesperson,Marketing,Travel Agent',
        6 => 'Nurse,Teacher,Counselor',
        7 => 'Scientist,Philosopher,Detective',
        8 => 'Business Owner,Politician,Consultant',
        9 => 'Doctor,Lawyer,Clergy',
        11 => 'Teacher,Artist,Philosopher',
        22 => 'Architect,Engineer,Politician',
        33 => 'Humanitarian,Counselor,Teacher'
    ];

    if (isset($positiveTraits[$number]) && isset($negativeTraits[$number]) && isset($descriptions[$number]) && isset($professions[$number])) {
        return [
            'positiveTraits' => $positiveTraits[$number],
            'negativeTraits' => $negativeTraits[$number],
            'description' => $descriptions[$number],
            'professions' => $professions[$number],
        ];
    } else {
        return "Invalid number. Please enter a number between 1 and 9, or 11, 22, 33.";
    }
}

// Function to get Soul Urge Number keywords
function getSoulUrgeKeywords($number)
{
    $motivations = [
        1 => "Achievement,Independence,Exploration",
        2 => "Harmony,Partnership,Tranquility",
        3 => "Creativity,Expression,Socializing",
        4 => "Stability,Structure,Order",
        5 => "Adventure,Freedom,Change",
        6 => "Home,Family,Service",
        7 => "Understanding,Wisdom,Reflection",
        8 => "Success,Recognition,Material Wealth",
        9 => "Universal Love,Philanthropy,Compassion",
        11 => "Illumination,Inspiration,Spiritual Insight",
        22 => "Building Dreams,Large Endeavors,Philanthropy",
        33 => "Guidance,Compassion,Benevolent Power"
    ];
        $demotivations = [
        1 => "Restrictions,Dependence",
        2 => "Conflict,Isolation",
        3 => "Repression,Solitude",
        4 => "Chaos,Uncertainty",
        5 => "Conformity,Routine",
        6 => "Disorder,Selfishness",
        7 => "Ignorance,Noise",
        8 => "Failure,Invisibility",
        9 => "Selfishness,Hatred",
        11 => "Reality,Criticism",
        22 => "Small Thinking,Selfishness",
        33 => "Selfishness,Negativity"
    ];
    $suggest_motivations = [
        1 => "Seek out leadership roles and create your own path. Avoid environments that restrict your autonomy and freedom of decision-making.",
        2 => "Strive to maintain harmony in your relationships and seek out cooperative tasks. Avoid situations that lead to conflict or force you to work in isolation.",
        3 => "Engage in creative activities and express your ideas. Avoid restrictive environments where your creativity is stifled.",
        4 => "Plan your tasks and follow structured routines. Avoid unpredictable situations or environments that lack order.",
        5 => "Embark on new adventures and embrace change. Avoid monotonous routines or environments that limit your freedom of choice.",
        6 => "Prioritize time with family and engage in acts of service. Avoid situations that promote selfishness or create disorder in your personal life.",
        7 => "Invest time in learning and self-reflection. Avoid environments that discourage intellectual growth or invade your personal space.",
        8 => "Set ambitious goals and work hard to achieve them. Avoid situations where your efforts are not recognized or rewarded.",
        9 => "Involve yourself in charitable activities and promote compassion. Avoid environments that encourage selfishness or intolerance.",
        11 => "Find time for spiritual practices and inspiring others. Avoid harsh criticism and environments that discourage dreaming and visualization.",
        22 => "Strive to turn big dreams into reality and work on large-scale projects. Avoid thinking small or being in self-centered environments.",
        33 => "Use your abilities to guide and support others. Avoid environments that promote selfishness or negativity."
    ];

    if (isset($motivations[$number]) && isset($demotivations[$number]) && isset($suggest_motivations[$number])) {
        return [
            'motivations' => $motivations[$number],
            'demotivations' => $demotivations[$number],
            'suggestions' => $suggest_motivations[$number]
        ];
    } else {
        return "Invalid number. Please enter a number between 1 and 9, or 11, 22, 33.";
    }
}

// Function to get Personality Number keywords
function getPersonalityKeywords($number)
{
    $keywords = [
        1 => "Ambitious, Assertive, Independent",
        2 => "Peaceful, Diplomatic, Cooperative",
        3 => "Sociable, Creative, Optimistic",
        4 => "Stable, Disciplined, Dependable",
        5 => "Adventurous, Energetic, Curious",
        6 => "Caring, Responsible, Loving",
        7 => "Introspective, Analytical, Intellectual",
        8 => "Authoritative, Businesslike, Powerful",
        9 => "Compassionate, Generous, Tolerant"
    ];
    return $keywords[$number];
}

// Function to get Birth Day Number keywords
function getBirthDayKeywords($number)
{
    $keywords = [
        1 => "Leadership, Boldness, Initiative",
        2 => "Diplomacy, Cooperation, Sensitivity",
        3 => "Creativity, Optimism, Expressiveness",
        4 => "Dependability, Discipline, Practicality",
        5 => "Adventure, Freedom, Versatility",
        6 => "Harmony, Responsibility, Compassion",
        7 => "Introspection, Spirituality, Wisdom",
        8 => "Authority, Achievement, Recognition",
        9 => "Humanitarian, Generosity, Tolerance"
    ];
    return $keywords[$number];
}

// Function to get Maturity Number keywords
function getMaturityKeywords($number)
{
    $keywords = [
        1 => "Independence, Ambition, Initiative",
        2 => "Diplomacy, Cooperation, Balance",
        3 => "Creativity, Self-Expression, Social",
        4 => "Stability, Discipline, Practicality",
        5 => "Freedom, Change, Adventure",
        6 => "Nurturing, Responsibility, Harmony",
        7 => "Wisdom, Spirituality, Intellectual",
        8 => "Power, Success, Business",
        9 => "Humanitarian, Compassion, Completion",
        11 => "Enlightenment, Visionary, Inspiration",
        22 => "Master Builder, Manifestation, Leadership",
        33 => "Master Teacher, Humanitarian, Guidance"
    ];
    return $keywords[$number];
}

?>

