<?php
$lang->google_title="Google indexing support module";
$lang->google_welcome="
The fields below are related to supporting indexing your shop's pages for search engines (especially www.google.com).<br>
Please read the notes related to specific fields before enetering any data.
For addictional information please visit <a href=\"http://www.google.com/webmasters/sitemaps/docs/en/about.html\">www.google.com</a>";
$lang->google_submit="Generate static pages";
$lang->google_products_title="Generating static pages";
$lang->google_menu=array("config"=>"Configuration","gen"=>"Generate static HTML pages");
$lang->google_config_title="Configure parameter related to indexing";
$lang->google_config_form=array("http_user_agents"=>"Definitions of USER_AGENT's of indexing systems<br> like. \"Google, WebCrawl\"",
                                "keywords"=>"Comma separated list of keywords (max 128 characters totall)",
                                "sentence"=>"A sentence describing the keyword ",
                                "title"=>"Site title",
                                "description"=>"Site description (max 128 characters) ",
                                "logo"=>"<nobr>Your sites logo in PNG, GIF or JPG format</nobr><br />\n(up to 300 pixels in width and/or height)",                                
                                "keyword_plain"=>"[*] Enter one of the keywords without your localized character encoding<br /> only characters ranging from a-z, 0-9 and spaces",
                               );
$lang->google_categories="Categories:";                               
$lang->google_user_agent_error="Invalid USER_AGENT, the browser will be ignored";
$lang->google_help="
Some tips to better optimize the indexing in Google:<br />
<ol>
  <li><b>Site title</b><br />
  	The sites title should be a full sentence. The most important keyword should not beggin the sentence.
  </li>
  <li><b>Keywords</b><br />
  The most important keywords should be listed first. Seperate keywords with a comma character (\",\").
  Enter at least 3 keywords - no less !.
  Do not repeat the keywords.
  The first entered keyword will be the main one and the shop will be optimised towards it.
  </li>
  <li><b>Sentences assigned to keywords</b><br />
  Assing a sentence to every keyword entered that contains the given keyword. Try to insert the main keyword in to the first 3 sentences.
  </li>
  <li><b>Site description</b><br />
  The sites description should be composed of natural sentences (max 128 characters) not containing HTML tags. Try to insert the main keyword into the description, but dont make it the first the first word.
  </li>
  <li><b>Keywords witout local characters</b><br />
  Insert the keywords without local characters. Keywords without local characters have a higher priority when the search engine indexes a page.
  </li>
  <li><b>Logo</b><br />
  Attach a small logo - it willbe helpfull when indexing the page. A good method is to name the file with the main keyword ie. \"myshop.gif\" etc.
  (it is recommended that the filename does not contain local characters).
  </li>
</ol>
";
$lang->google_info_gen="<p />\n
Generating static pages produces static HTML pages with relevant content according to the contents of the shops dynamic pages. 
It is recommended to execute this procedure once a week or two.";
$lang->google_add="
After generating the static pages, add your site to the googles database: <br />
<li> www.google.com <a href=\"http://www.google.com/addurl\" target=\"google\"><b><u>add</b></u></a></li>
";
$lang->google_error_keyword_plain="Invalid field name [*]. Use only characters ranging from a-z 0-9 and spaces";
$lang->google_logo="Preview your logo";
$lang->google_go2gen="
CAUTION! After changing your settings run \"Generate static HTML pages\" to update the changes!";
$lang->google_www_text="E-Store: ";
?>