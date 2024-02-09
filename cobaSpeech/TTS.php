<?php


// $file = '../sound/people3.wav';
// // Open the file to get existing content
// $text = "siswa Gilbert Kelas 7B telah di jemput. harap bersiap di lobby utara.";
// $text = str_replace(" ", "+", $text);
// $current = file_get_contents("https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=" . $text . "&tl=id-ID");

// // Append a new person to the file
// // Write the contents back to the file
// file_put_contents($file, $current);


if (isset($_POST['submit'])) {
    $myAudioFile = "people.mp3";
    echo '<audio autoplay="true" style="display:none;">
         <source src="' . $myAudioFile . '" type="audio/wav">
      </audio>';
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h1>SISTEM PEMBERITAHAUN SUARA</h1>
    <form method="post">
        <input id="txt" name="txt" type="textbox" />
        <input name="submit" type="submit" name="submit" value="Convert to Speech" />
    </form>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script>
        //This plays a file, and call a callback once it completed (if a callback is set)
        $(document).ready(function() {
        //     console.log("start");
            var urlParams = new URLSearchParams(window.location.search);
            var gradeParam = urlParams.get('grade');

            
            let playSound = false;
            getSound();
            

            function getSound() {
                console.log("get sound");
                $.ajax({
                    url: "../api/getSound.php",
                    dataType: "json",
                    type: "GET",
                    data: {
                        grade: gradeParam,
                    },
                    success: function(data) {
                        console.log(data["sound"]);
                        var sounds = [];
                        data["sound"].forEach(element => {
                            sounds.push(new Audio("../sound/" + element));
                        });

                        console.log(sounds);
                        play_sound_queue(sounds);
                    }
                })
            }


            function play(audio, callback) {
                setTimeout(function() {
                    audio.play();
                    console.log(audio.currentSrc);
                    if (callback) {
                        //When the audio object completes it's playback, call the callback
                        //provided      
                        audio.addEventListener('ended', callback);
                    }
                }, 2000);

            }

            //Changed the name to better reflect the functionality
            function play_sound_queue(sounds) {
                var index = 0;

                function recursive_play() {
                    //If the index is the last of the table, play the sound
                    //without running a callback after       
                    console.log(index)
                    console.log(gradeParam);
                    // console.log(sounds[index].currentSrc);


                    if (sounds.length == 0) {
                        console.log("empty");
                        setTimeout(function() {
                            getSound();
                        }, 2000);
                    } else if (index + 1 === sounds.length) {
                        // console.log(index);
                        play(sounds[index], function() {
                            getSound();
                        });
                    } else {
                        //Else, play the sound, and when the playing is complete
                        //increment index by one and play the sound in the 
                        //indexth position of the array
                        play(sounds[index], function() {
                            index++;
                            // console.log(index);
                            recursive_play();
                        });
                    }
                }

                //Call the recursive_play for the first time
                recursive_play();
            }
        });
    </script>
</body>

</html>