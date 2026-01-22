<?php
// Simple dictionary for live search suggestions
// When user types a keyword, we show matching suggestion

$dictionary = [
    // Vegetables - Bangla
    "alu" => "Alu (Potato)",
    "potato" => "Alu (Potato)",
    "begun" => "Begun (Brinjal)",
    "brinjal" => "Begun (Brinjal)",
    "patol" => "Patol (Pointed Gourd)",
    "lau" => "Lau (Bottle Gourd)",
    "korola" => "Korola (Bitter Gourd)",
    "shim" => "Shim (Bean)",
    "dherosh" => "Dherosh (Okra)",
    "gajor" => "Gajor (Carrot)",
    "carrot" => "Gajor (Carrot)",
    "mula" => "Mula (Radish)",
    "shosha" => "Shosha (Cucumber)",
    "cucumber" => "Shosha (Cucumber)",
    "tomato" => "Tomato",
    "peyaj" => "Peyaj (Onion)",
    "onion" => "Peyaj (Onion)",
    "roshun" => "Roshun (Garlic)",
    "garlic" => "Roshun (Garlic)",
    "ada" => "Ada (Ginger)",
    "ginger" => "Ada (Ginger)",
    "fulkopi" => "Fulkopi (Cauliflower)",
    "badhakopi" => "Badhakopi (Cabbage)",
    "kumra" => "Kumra (Pumpkin)",
    "morich" => "Morich (Chili)",
    "jhinga" => "Jhinga (Ridge Gourd)",
    "dhundul" => "Dhundul (Sponge Gourd)",
    "chichinga" => "Chichinga (Snake Gourd)",
    "kachu" => "Kachu (Taro)",
    "data" => "Data Shak (Amaranth)",
    "motor" => "Motor (Peas)",
    "sojne" => "Sojne (Drumstick)",

    // Fruits - Bangla
    "aam" => "Aam (Mango)",
    "mango" => "Aam (Mango)",
    "kola" => "Kola (Banana)",
    "banana" => "Kola (Banana)",
    "apple" => "Apple",
    "komola" => "Komola (Orange)",
    "orange" => "Komola (Orange)",
    "pepe" => "Pepe (Papaya)",
    "papaya" => "Pepe (Papaya)",
    "tormuj" => "Tormuj (Watermelon)",
    "watermelon" => "Tormuj (Watermelon)",
    "kathal" => "Kathal (Jackfruit)",
    "jackfruit" => "Kathal (Jackfruit)",
    "litchi" => "Litchi",
    "peyara" => "Peyara (Guava)",
    "guava" => "Peyara (Guava)",
    "narikel" => "Narikel (Coconut)",
    "coconut" => "Narikel (Coconut)",
    "angur" => "Angur (Grape)",
    "grape" => "Angur (Grape)",
    "anarosh" => "Anarosh (Pineapple)",
    "pineapple" => "Anarosh (Pineapple)",
    "lebu" => "Lebu (Lemon)",
    "lemon" => "Lebu (Lemon)",
    "dalim" => "Dalim (Pomegranate)",
    "bangi" => "Bangi (Musk Melon)",
    "muskmelon" => "Bangi (Musk Melon)",
    "bel" => "Bel (Wood Apple)",
    "kamranga" => "Kamranga (Star Fruit)",
    "jambura" => "Jambura (Pomelo)",
    "boroi" => "Boroi (Jujube)",
    "taal" => "Taal (Palm Fruit)",
    "sofeda" => "Sofeda (Sapodilla)",
    "amra" => "Amra (Hog Plum)",
    "tetul" => "Tetul (Tamarind)",

    // Meat - Bangla
    "mangso" => "Mangso (Meat)",
    "meat" => "Mangso (Meat)",
    "murgi" => "Murgi (Chicken)",
    "chicken" => "Murgi (Chicken)",
    "gorur" => "Gorur Mangso (Beef)",
    "beef" => "Gorur Mangso (Beef)",
    "khasir" => "Khasir Mangso (Mutton)",
    "mutton" => "Khasir Mangso (Mutton)",
    "mach" => "Mach (Fish)",
    "fish" => "Mach (Fish)",
    "ilish" => "Ilish (Hilsa)",
    "rui" => "Rui Fish",
    "katla" => "Katla Fish",
    "chingri" => "Chingri (Shrimp)",
    "shrimp" => "Chingri (Shrimp)",
    "dim" => "Dim (Egg)",
    "egg" => "Dim (Egg)",

    // Common
    "chal" => "Chal (Rice)",
    "rice" => "Chal (Rice)",
    "dal" => "Dal (Lentils)",
    "dudh" => "Dudh (Milk)",
    "milk" => "Dudh (Milk)"
];

// Get keyword from URL
$keyword = strtolower(trim($_GET["keyword"] ?? ""));

if ($keyword == "") {
    echo "";
    exit;
}

// Find matching suggestion
$suggestion = "";

// First try exact match
if (isset($dictionary[$keyword])) {
    $suggestion = $dictionary[$keyword];
} else {
    // Try partial match (keyword diyeshuru hoy)
    foreach ($dictionary as $key => $value) {
        if (strpos($key, $keyword) === 0) {
            $suggestion = $value;
            break;
        }
    }
}

// Output clickable suggestion
if ($suggestion != "") {
    // onclick="selectSuggestion('Alu')" - ei function dashboard e ache
    // suggestion click korle filterProducts() call hobe
    echo "<span class='suggestion-item' onclick=\"selectSuggestion('$suggestion')\" 
          style='cursor:pointer; background:#e8f5e9; padding:5px 10px; border-radius:5px;'>
          FILTER BY: $suggestion (Click to filter)
          </span>";
} else {
    echo "<span style='color:#999;'>No suggestion found</span>";
}
