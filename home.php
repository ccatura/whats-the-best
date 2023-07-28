

<!-- <img class="home-image" src="https://loremflickr.com/500/500/videogame"> -->
<!-- <img class="home-image" src="https://loremflickr.com/500/500/retrogaming"> -->
<!-- <img class="home-image" src="https://loremflickr.com/500/500/atari2600"> -->
<!-- <img class="home-image" src="https://loremflickr.com/500/500/colecovision"> -->
<!-- <img class="home-image" src="https://loremflickr.com/500/500/1980s"> -->
<!-- <img class="home-image" src="https://loremflickr.com/500/500/commodore64"> -->



<?php

$user_name = $_SESSION['user_name'];

echo "<img class='home-image' src='./images/user_pics/{$user_name}_large.jpg' onerror='this.style.opacity=0'>";



echo "<h2>Current Champion in Total Votes</h2>";
echo get_top_stats($conn);




// second place: runner up
// third place: 