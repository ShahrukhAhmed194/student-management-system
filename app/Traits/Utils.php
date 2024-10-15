<?php
namespace App\Traits;

trait Utils{

    public function getUniqueId($length){

      $random_id = substr(str_shuffle(str_repeat($x='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', ceil($length/strlen($x)) )),1,$length);
    
      return $random_id;
    }

    public function getCountryList(){
      
      $countries = array(
        "Bangladesh","Afghanistan","Åland Islands", "Albania", "Algeria", "American Samoa",
        "Andorra","Angola","Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina",
        "Armenia","Aruba","Australia", "Austria", "Azerbaijan", "Bahamas",
        "Bahrain","Barbados","Belarus", "Belgium", "Belize", "Benin",
        "Bermuda","Bhutan","Bolivia", "Bonaire", "Bosnia and Herzegovina", "Botswana",
        "Bouvet Island","Brazil","British Indian Ocean Territory", "Brunei", "Bulgaria", "Burkina Faso",
        "Burundi","Cambodia","Cameroon", "Canada", "Cape Verde", "Cayman Islands",
        "Central African Republic","Chad","Chile", "China", "Christmas Island", "Cocos (Keeling) Islands",
        "Colombia","Comoros","Congo", "Cook Islands", "Costa Rica", "Croatia",
        "Cuba","Curaçao","Cyprus", "Czech Republic", "Denmark", "Djibouti",
        "Dominica","Dominican Republic","Ecuador", "Egypt", "El Salvador", "Equatorial Guinea",
        "Eritrea","Estonia","Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji",
        "Finland","France","French Guiana", "French Polynesia", "French Southern Territories", "Gabon",
        "Gambia","Georgia","Germany", "Ghana", "Gibraltar", "Greece",
        "Greenland","Grenada","Guadeloupe", "Guam", "Guatemala", "Guernsey",
        "Guinea","Guinea-Bissau","Guyana", "Haiti", "Honduras", "Hong Kong",
        "Hungary","Iceland","India", "Indonesia", "Iran", "Iraq",
        "Ireland","Isle of Man","Italy", "Ivory Coast", "Jamaica", "Japan",
        "Jersey","Jordan","Kazakhstan", "Kenya", "Kiribati", "Kuwait",
        "Kyrgyzstan","Laos","Latvia", "Lebanon", "Lesotho", "Liberia",
        "Libya","Liechtenstein","Lithuania", "Luxembourg", "Macao", "Macedonia",
        "Madagascar","Malawi","Malaysia", "Maldives", "Mali", "Malta",
        "Marshall Islands","Martinique","Mauritania", "Mauritius", "Mayotte", "Mexico",
        "Micronesia","Moldova","Monaco", "Mongolia", "Montenegro", "Montserrat",
        "Morocco","Mozambique","Myanmar", "Namibia", "Nauru", "Nepal",
        "Netherlands","New Caledonia","New Zealand", "Nicaragua", "Niger", "Nigeria",
        "Niue","Norfolk Island","North Korea", "Northern Mariana Islands", "Norway", "Oman",
        "Pakistan","Palau","Palestine", "Panama", "Papua New Guinea", "Paraguay",
        "Peru","Philippines","Pitcairn", "Poland", "Portugal", "Puerto Rico",
        "Qatar","Réunion","Romania", "Russian Federation", "Rwanda", "Saint Barthélemy",
        "Saint Helena, Ascension and Tristan da Cunha","Saint Kitts and Nevis","Saint Lucia", "Saint Martin (French part)", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines",
        "Samoa","San Marino","Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia",
        "Seychelles","Sierra Leone","Singapore", "Sint Maarten (Dutch part)", "Slovakia", "Slovenia",
        "Solomon Islands","Somalia","South Africa", "South Georgia and the South Sandwich Islands", "South Korea", "South Sudan",
        "Spain","Sri Lanka","Sudan", "Suriname", "Svalbard and Jan Mayen", "Swaziland",
        "Sweden","Switzerland","Syrian Arab Republic", "Taiwan", "Tajikistan", "Tanzania",
        "Thailand","Timor-Leste","Togo", "Trinidad and Tobago", "Tokelau", "Tonga",
        "Tunisia","Turkey","Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda",
        "Ukraine","United Arab Emirates","United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay",
        "Uzbekistan","Vanuatu","Vatican City", "Venezuela", "Viet Nam", "Virgin Islands, British",
        "Virgin Islands, U.S.","Wallis and Futuna","Western Sahara", "Yemen", "Zambia", "Zimbabwe"
      );

      return $countries;
    }

    public function getReligionList(){

      $religions = array(
        "African Traditional &amp; Diasporic", "Agnostic", "Atheist", "Baha'i", "Buddhism",
        "Cao Dai", "Chinese traditional religion", "Christianity", "Hinduism", "Islam",
        "Jainism", "Juche", "Judaism", "Neo-Paganism", "Nonreligious",
        "Rastafarianism", "Secular", "Shinto", "Sikhism", "Spiritism",
        "Tenrikyo", "Unitarian-Universalism", "Zoroastrianism", "primal-indigenous", "Other"
      );

      return $religions;
    }

    public function getMonthsList(){
      $months = array(
        'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
      );

      return $months;
    }

    public function getTrackFromAge($age)
    {
      if($age>=7 && $age<=8){
        return 'Track-1';
      }elseif($age>=9 && $age<=10){
        return 'Track-2';
      }elseif($age>=11 && $age<=16){
        return 'Track-3';
      }else{
        return 'Wrong Age';
      }
    }
}