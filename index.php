<?php
  
//output csv file, edited with new values
if (!FILE_EXISTS("test.csv"))
{
              require_once('/Requests/library/Requests.php');
              Requests::register_autoloader();

              $base = 'USD';
              $newCsvData = array();

              if (($handle = fopen("list.csv", "r")) !== FALSE) {
                  while (($data = fgetcsv($handle)) !== FALSE) {

                    $dat = substr($data[0], 0, 4)."-".substr($data[0], 4, 2)."-".substr($data[0], 6, 2);
                        $request = Requests::get('https://api.fixer.io/'.$dat.'?base=' . $base, array('Accept' => 'application/json'));
                        if ($request->status_code == 200) 
                        {
                          $response = json_decode($request->body);
                          $SGD = $response->rates->SGD;

                          $str1 = floatval(str_replace( ',', '',ltrim($data[2], '$')) );
                          $str2 = floatval(str_replace( ',', '',ltrim($data[3], '$')) );
                          $str3 = floatval(str_replace( ',', '',ltrim($data[4], '$')) );
                          

                           $date = substr($data[0], 0, 4)."-".substr($data[0], 4, 2)."-".substr($data[0], 6, 2);
                           $request = Requests::get('https://api.fixer.io/'.$date.'?base=' . $base, array('Accept' => 'application/json'));
                           if ($request->status_code == 200) 
                        {
                          $response = json_decode($request->body);
                          $SGD = $response->rates->SGD;
                        }

                      $data[] = "$".(string)round($str1 * $SGD, 2);
                      $data[] = "$".(string)round($str2 * $SGD, 2);
                      $data[] = "$".(string)round($str3 * $SGD, 2);
                      $newCsvData[] = $data;
                        }
                        else
                        {
                         
                          $data[] = 'FOOLX Price SGD ';
                          $data[] = 'TMFGX Price SGD';
                          $data[] = 'TMFFIB Price SGD';
                            $newCsvData[] = $data;
                        }
                      
                    
                  }
                  fclose($handle);
              }

              $handle = fopen('test.csv', 'w');

              foreach ($newCsvData as $line) {
                 fputcsv($handle, $line);
              }
              fclose($handle);

}


?>

<html>
<head>
    
  <style>

            html, body {
                height: 100%;
            }
           
           #status
           {
                margin-top: 191px;
                position: absolute;
                margin-left: 19px;
                font-size: medium;
                font-weight: 300;
                width: 600px;

           }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
                background-color: #f7f7f7;
            }

            .container-fluid {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .panel-body{
                  background-color: lightsteelblue;
                  width: 696px;
                  height: 770px;
                  margin-left: 181px;
                  margin-top: 15px;
                  border: 2px solid black;
      }

      .panel-heading
      {
            font-size: x-large;
            position: absolute;
            margin-left: 428px;
            margin-top: -11px;
      }

            

      


</style>




<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>




</head> 

<body >
<div class="container-fluid">
  <div class="row">
        
  
  <div class="panel-heading">The Motley Fool</div>
  <br><div class="panel-body">

<div id="status">
        
<?php 

   if ($_SERVER['REQUEST_METHOD'] == 'POST') 
      {
          echo $a = rates();
          
         
      }
      else
       {
          header('content-type: text/html; charset=utf-8');
      }


      function rates()
      {
        $date = $_POST["date"];
        $type = $_POST["type"];


        $f = fopen("test.csv", "r");
        $i =0;
        $j = 0;
        $k = 0;
        $l = 0;
        $n = 0;


       /* if($date == "Both")
            $b = "Date: 2017-07-24, 2017-07-25<br> Type: ".$type."<br><br>";
        else
            $b = "Date: ".substr($date, 0, 4)."-".substr($date, 4, 2)."-".substr($date, 6, 2) ."<br>".$type."<br><br>";*/
        

        $a = "<table style='border:1px solid black; border-collapse: collapse; margin-top: -34px;'>\n\n";
         $a = $a."<tr style='border:1px solid black; border-collapse: collapse;'>";
        

          
          if ($date != "Both")
          {
                   //$a = $a."<td style='border:1px solid black; border-collapse: collapse;'>".substr($date, 0, 4)."-".substr($date, 4, 2)."-".substr($date, 6, 2). "</td>";            
                  foreach ($type as $key ) {
                   if($key == "FOOLX Price USD")
                        {
                          $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price USD</td>";
                          $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price SGD</td>";
                        }
                    if($key == "TMFGX Price USD")
                        {
                          $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price USD</td>";
                          $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price SGD</td>";
                        }

                    if($key == "TMFFIB Price USD")
                        {
                          $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price USD</td>";
                          $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price SGD</td>";
                        }
                    if($key == "ALL")
                        {
                            $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price USD</td>";
                            $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price USD</td>";
                            $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price USD</td>";
                            $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price SGD</td>";
                            $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price SGD</td>";
                            $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price SGD</td>";
                        }
                  }
                  $i++;
                  
         }

          /*if (($date == "Both") &&($type[0] == "ALL" ))
          {


                $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price USD</td>";
                $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price USD</td>";
                $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price USD</td>";
                $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price SGD</td>";
                $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price SGD</td>";
                $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price SGD</td>";
                
          }*/

          $a = $a."</tr>";


        while ($row = fgetcsv($f)) 
        {
                  $a = $a."<tr style='border:1px solid black; border-collapse: collapse;'>";
                  

                
                  if (($row[0] == $date) &&(in_array("FOOLX Price USD", $type) ) )
                  {
                     
                        $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[2]) . "</td>";
                        $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[5]) . "</td>";
                        $i++;

                       
                  }

                  if (($row[0] == $date) &&(in_array("TMFGX Price USD", $type)))
                  {
                        
                        $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[3]) . "</td>";
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[6]) . "</td>";
                        $i++;
                        
                  }

                  if (($row[0] == $date) &&(in_array("TMFFIB Price USD", $type) ))
                  {
                      
                       $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[4]) . "</td>";
                       $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[7]) . "</td>";
                        $i++;
                       
                  }
                  if (($row[0] == $date) &&($type[0] == "ALL" ))
                  {
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[2]) . "</td>";
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[5]) . "</td>";
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[3]) . "</td>";
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[6]) . "</td>";
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[4]) . "</td>";
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[7]) . "</td>";
                        $j++;
                        $n++;
                        
                   }

                  





               
                  if (($date == "Both") &&(in_array("FOOLX Price USD", $type) ))
                  {
                        
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[2]) . "</td>";
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[5]) . "</td>";
                        $k++;
                      
                  }
                  if (($date == "Both") &&(in_array("TMFGX Price USD", $type)))
                  {
                  
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[3]) . "</td>";
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[6]) . "</td>";
                         $k++;
                        
                        
                  }
                  if (($date == "Both") &&(in_array("TMFFIB Price USD", $type)))
                  {            
                        
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[4]) . "</td>";
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[7]) . "</td>";
                         $k++;
                       
                       
                  }


                  if (($date == "Both") &&($type[0] == "ALL" ))
                  {
                        

                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[2]) . "</td>";
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[5]) . "</td>";
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[3]) . "</td>";
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[6]) . "</td>";
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[4]) . "</td>";
                        $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>" . htmlspecialchars($row[7]) . "</td>";
                         $l++;
                  }

                    


//paginate
                    
                    if($date == "Both")
                      {
                          if($type[0] == "ALL")
                           {
                              
                              if(($l % 6 == 0) && ($l != 0))
                              {
                                    $a = $a. '</tr></table><br><table>';
                                    $a = $a."<tr><td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price USD</td>";            
                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price SGD</td>";
                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price USD</td>";            
                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price SGD</td>";
                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price USD</td>";            
                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price SGD</td></tr>";
                                    $l = 1;

                              }
                          }
                          else if($type[0] != "ALL")
                          {
                            
                                  $line = count($type);
                                  if($line == 2)
                                  {
                                 
                                  if(($k  == 12) || ($k == 22) || ($k == 32) || ($k == 42))
                                    {
                                         $a = $a. '</tr></table><br><table>';
                                        foreach ($type as $key) 
                                          {
                                               if($key == "FOOLX Price USD")
                                                {
                                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price USD</td>";
                                                  $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price SGD</td>";
                                                }
                                                if($key == "TMFGX Price USD")
                                                {
                                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price USD</td>";
                                                    $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price SGD</td>";
                                                }

                                                if($key == "TMFFIB Price USD")
                                                {
                                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price USD</td>";
                                                    $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price SGD</td>";
                                                }
                                          }
                                          $k = 2;

                                    }
                                  }   //line 2
                                  else if($line == 1)
                                  {
                                           
                                          if(($k  == 6) || ($k == 11) || ($k == 16) || ($k == 21))
                                            {
                                                 $a = $a. '</tr></table><br><table>';
                                                foreach ($type as $key) 
                                                  {
                                                       if($key == "FOOLX Price USD")
                                                        {
                                                            $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price USD</td>";
                                                          $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price SGD</td>";
                                                        }
                                                        if($key == "TMFGX Price USD")
                                                        {
                                                            $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price USD</td>";
                                                            $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price SGD</td>";
                                                        }

                                                        if($key == "TMFFIB Price USD")
                                                        {
                                                            $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price USD</td>";
                                                            $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price SGD</td>";
                                                        }
                                                  }
                                                  $k = 1;
                                                  

                                            }

                                        }//line 1 else end

                                      }  // if not all end 
                      }     // if both end
                      else
                      {
                        if($date != "Both")
                        {
                          if($type[0] == "ALL")
                          {
                            
                            if(($j % 5 == 0) && ($j != 0)&&($n != 9))
                              {
                                    $a = $a. '</tr></table><br><table>';
                                    $a = $a."<tr><td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price USD</td>";            
                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price SGD</td>";
                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price USD</td>";            
                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price SGD</td>";
                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price USD</td>";            
                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price SGD</td></tr>";
                                    $j = 1;

                              }

                          }
                          else if($type[0] != "ALL")
                          {
                           
                          $line = count($type);
                                  if($line == 2)
                                  {
                                 
                                  if(($i  == 6) || ($i == 11) )
                                    {
                                         $a = $a. '</tr></table><br><table>';
                                        foreach ($type as $key) 
                                          {
                                               if($key == "FOOLX Price USD")
                                                {
                                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price USD</td>";
                                                  $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price SGD</td>";
                                                }
                                                if($key == "TMFGX Price USD")
                                                {
                                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price USD</td>";
                                                    $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price SGD</td>";
                                                }

                                                if($key == "TMFFIB Price USD")
                                                {
                                                    $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price USD</td>";
                                                    $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price SGD</td>";
                                                }
                                          }
                                          $k = 2;

                                    }
                                  }   //line 2
                                  else if($line == 1)
                                  {
                                           
                                          if(($i  == 6) || ($i == 11) )
                                            {
                                                 $a = $a. '</tr></table><br><table>';
                                                foreach ($type as $key) 
                                                  {
                                                       if($key == "FOOLX Price USD")
                                                        {
                                                            $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price USD</td>";
                                                          $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>FOOLX Price SGD</td>";
                                                        }
                                                        if($key == "TMFGX Price USD")
                                                        {
                                                            $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price USD</td>";
                                                            $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFGX Price SGD</td>";
                                                        }

                                                        if($key == "TMFFIB Price USD")
                                                        {
                                                            $a = $a."<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price USD</td>";
                                                            $a = $a. "<td style='border:1px solid black; border-collapse: collapse;'>TMFFIB Price SGD</td>";
                                                        }
                                                  }
                                                  $k = 1;
                                                  

                                            }

                                        }//line 1 else end




                                      }  // if not all end 




                        }

                      }







                  
                  

          }
          $a = $a. "</table>";
        
    fclose($f);
    return $a;
      } 
      

      
?> 

</div>

    <form id = "Webint" class="form-inline" name ="webint"  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      Select a date.
      <select style="margin-left: 137px;" id ="date" class="form-control" name="date" required>
          <option value=""></option>
          <option value="20170724"
            <?php 
          if(isset($_POST['date']) && $_POST['date'] == '20170724') 
         echo 'selected= "selected"'; 
       ?>
          >2017-07-24</option>


          <option value="20170725"
           <?php 
          if(isset($_POST['date']) && $_POST['date'] == '20170725') 
         echo 'selected= "selected"'; 
       ?>
       >2017-07-25
     </option>



          <option value="Both"
           <?php 
          if(isset($_POST['date']) && $_POST['date'] == 'Both') 
         echo 'selected= "selected"'; 
       ?>
       >Both
     </option>


      </select>

      <br>Select the Price in USD 
      <select style="margin-left: 100px;" id="type" class="form-control" name="type[]" required multiple= "multiple">
          
          <option value="FOOLX Price USD" <?php if(isset($_POST['type']) && in_array('FOOLX Price USD',$_POST['type'])) echo ' selected'; ?>
          
         >FOOLX</option>

          <option value="TMFGX Price USD" <?php if(isset($_POST['type']) && in_array('TMFGX Price USD',$_POST['type'])) echo ' selected'; ?>
          
          >TMFGX</option>


          <option value="TMFFIB Price USD" <?php if(isset($_POST['type']) && in_array('TMFFIB Price USD',$_POST['type'])) echo ' selected'; ?>
          
         >TMFFIB</option>


         <option value="ALL" <?php if(isset($_POST['type']) && in_array('ALL',$_POST['type'])) echo ' selected'; ?>
          
         >ALL</option>

          
      </select>
      <br>
      <input type="submit" value = "submit" id ="submit" class="btn btn-primary"/>

      
  </form> 

</div>

</div>
</div>

<script type="text/javascript">

  document.getElementById('date').value = "<?php if(isset($_POST['date'])) echo $_POST['date'];?>";
  //document.getElementById('type').value = "<?php if(isset($_POST['type'])) echo $_POST['type'];?>";

</script>

</body>
</html>