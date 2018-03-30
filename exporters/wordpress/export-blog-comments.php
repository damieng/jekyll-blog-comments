<html>
<title>Export WordPress blog comments</title>
<body>
<pre>                                                                                                                         
<?php error_reporting(-1);                                                                                                    
require('wp-blog-header.php');                                                                                                
$comments=get_comments(array('status' => 'approve', 'type' => 'comment', 'orderby'=>'comment_post_ID'));                      
foreach($comments as $comment) :                                                                                              
$url=post_permalink($comment->comment_post_ID);                                                                               
$url=str_replace('https://damieng.com/', '', $url);                                                                           
$url=str_replace('blog/', '', $url);                                                                                          
$url=str_replace('/', '-', $url);                                                                                             
$url=get_post_field('post_name', $comment->comment_post_ID);                                                                  
$folder = dirname(__FILE__) .  "/comments/{$url}";                                                                            
if (!file_exists($folder)) {                                                                                                  
  echo "Creating folder {$folder}\n";                                                                                         
  mkdir($folder, 0777, true)  or die(print_r(error_get_last(),true));                                                         
}                                                                                                                             
$filename = "{$folder}/{$comment->comment_ID}.yml";                                                                           
echo "Writing to {$filename}\n";                                                                                              
$file = fopen($filename, 'w') or die(print_r(error_get_last(),true));                                                         
fputs($file, "id: {$comment->comment_ID}\n");                                                                                 
fputs($file, "name: {$comment->comment_author}\n");                                                                           
if ($comment->comment_author_email) {                                                                                         
  fputs($file, "email: {$comment->comment_author_email}\n");                                                                  
}                                                                                                                             
if ($comment->comment_author_url) {                                                                                           
  fputs($file, "url: {$comment->comment_author_url}\n");                                                                      
}                                                                                                                             
fputs($file, "date: {$comment->comment_date}\n");                                                                             
$encodedComment = $comment->comment_content;                                                                                  
$encodedComment=str_replace("\\", "\\\\", $encodedComment);                                                                   
$encodedComment=str_replace('"', '\"', $encodedComment);                                                                      
fputs($file, "message: \"{$encodedComment}\"\n");                                                                             
fclose($file);                                                                                                                
endforeach; ?>
Complete!
</pre>
</body>
</html>
