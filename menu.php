<?php

echo "<ul>";
foreach ($site_map as $section){
	$url = $section['name'];
	echo "<li>";
	echo "<a href='".$root.$url."'>";
	echo $section['title'];
	echo "</a>";
	echo "</li>";
}
echo "</ul>";


/*
echo "
<ul>
<li><a href='".$base_dir."bible-study/'>Bible Study</a></li>
<li><a href='".$base_dir."blog/'>Blog</a></li>
<li><a href='".$base_dir."events/'>Events</a></li>
<li><a href='".$base_dir."daily-bread/'>Daily Bread</a></li>
<li><a href='".$base_dir."about/'>About Us</a></li>
<li><a href='".$base_dir."contact/'>Contact</a></li>
<li><a href='".$base_dir."resources/'>Resources</a></li>
</ul>
";
*/



?>