<html>
  <head>
    <title>22年度国勢調査</title> <meta charset="utf-8">
  </head>
  <body>

    <h1>22年度国勢調査</h1> 


    <table border=0 cellpadding=0 cellspacing=0>
      <tr bgcolor=#87f820>
        <td width=50><br>No</td>
        <td width=100><br><b>都道府県名</b></td>
        <td width=80><br><b>人口(人)</b></td>
        <td width=150><br><b>人口増減数(人)<font size="1">※</font></b></td>
        <td width=120><br><b>面積(km2)</b></td>
        <td width=120><br><b>平均年齢(歳)</b></td>

<?php

if(isset($_GET['id'])) $id=$_GET['id']; 
if(isset($_GET['name'])) $name=$_GET['name']; 
if(isset($_GET['population']))  $population=$_GET['population']; 
if(isset($_GET['change_population']))     $change_population=$_GET['change_population']; 
if(isset($_GET['area']))     $area=$_GET['area']; 
if(isset($_GET['average_age']))     $average_age=$_GET['average_age'];
if(isset($_GET["sort"])){ $sort = $_GET['sort'] ;} else { $sort = 'id'; }
if(isset($_GET["sort_type"])){ $sort_type =$_GET['sort_type'] ;} else { $sort_type = 'ASC'; }
// デフォルトはsort="id",sort_type="ASC" 更新されたらチェックされてるものにする
$sort =utf2sjis($sort);  //sort,sor_typeをSJISにする
$sort_type =utf2sjis($sort_type);


$db = new PDO("sqlite:mydata.sqlite");
if(isset($name))	{
  $name=utf2sjis($name); //SJISに一旦戻す
  $db->query("INSERT INTO japan VALUES(null, '$name','$population','$change_population','$area','$average_age')");
}
if(isset($id))	{
  $db->query("DELETE FROM japan WHERE id='$id'");
}


$result=$db->query("SELECT * FROM japan ORDER by $sort $sort_type");

for($i = 0; $row=$result->fetch(); ++$i ){
  echo "<tr valign=center>";
  echo "<td >". $row['id']. "</td>";
  echo "<td >".h(sjis2utf(($row['name'])))."</td>";
  echo "<td >".h($row['population']). "</td>";
  echo "<td >".h($row['change_population']). "</td>";
  echo "<td >".h($row['area']). "</td>";
  echo "<td >".h($row['average_age']). "</td>";
  echo "</tr>";
}



function h($str){
  return htmlspecialchars($str,ENT_QUOTES,"utf-8");
}
function sjis2utf($str){ //Shift_JISからUTF-8にエンコードする関数
  return $str=mb_convert_encoding($str, "utf-8", "sjis"); 
}

function utf2sjis($str){ //UTF-8からShift_JISにエンコードする関数
  return $str=mb_convert_encoding($str,"sjis","utf-8");
}


 ?>

      <tr> <td bgcolor=#79fb22 colspan=8>&nbsp</td> </tr>
    </table><br>
    <font size="1">※平成17に対しての増減数</font>



    <h2>データのソート</h2>
    <form action=mydata.php method=get>
      <input type="radio" name=sort_type value="ASC" checked="checked">昇順 
      <input type="radio" name=sort_type value="DESC" >降順<br>
      <input type="radio" name=sort value="id" checked="checked">id
      <input type="radio" name=sort value="population">人口
      <input type="radio" name=sort value="change_population">人口増減数
      <input type="radio" name=sort value="area">面積
      <input type="radio" name=sort value="average_age">平均年齢
      <input type=submit border=0 value="更新">

    </form>

    <h2>他の都道府県のデータを追加</h2>
    <form action=mydata.php method=get> 

      <table border=0 cellpadding=0 cellspacing=0 >
        <tr><td>都道府県名:</td><td><input type=text size=20 name=name></td></tr>
        <tr><td>人口</td><td> <input type=text size=20 name=population></td></tr>
        <tr><td>人口増減数</td><td> <input type=text size=20 name=change_population></td></tr>
        <tr><td>面積</td><td> <input type=text size=20 name=area></td></tr>
        <tr><td>平均年齢:</td><td> <input type=text size=20 name=average_age></td></tr>
        <tr><td> </td><td><input type=submit border=0 value="追加"></td></tr>
      </table>
    </form>

    <h2>データを削除</h2>
    <form action=mydata.php method=get>
      <table border=0 cellpadding=0 cellspacing=0>
        <tr><td>ID:</td><td><input type=text size=20 name=id></td></tr>
        <tr><td> </td><td><input type=submit border=0 value="削除"></td></tr>
      </table>
    </form>

  </body>
</html>


