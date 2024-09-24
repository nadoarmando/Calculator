<?php
$display = '';
$input = [];
$is2ndButtonChecked = '0';
$isdegButtonChecked ='deg';
function getInputAsString($values){
    return implode('', $values);
}

function calculateInput($userInput){
  

    $expression = implode('', $userInput);
    // $expression = !7;

    // Evaluate the expression safely using eval (this should be avoided in production)
    try {
        $result = eval('return ' . $expression  .';');
    } catch (Exception $e) {
        $result = 'Error';
    }

    return $result;
}



if($_SERVER['REQUEST_METHOD']=='POST'){
    // $checkboxChecked = isset($_POST['rotate-checkbox']) ? 'checked' : '';
    /*check if 2nd Button is pressed */
    if (isset($_POST['toggle'])) {
        $is2ndButtonChecked = ($_POST['is2ndButtonChecked'] === '0') ? '1' : '0';
    } else {
        $is2ndButtonChecked = isset($_POST['is2ndButtonChecked']) ? $_POST['is2ndButtonChecked'] : '0';
    }
     /*check if deg Button is pressed */
     if(isset($_POST['deg-rad'])){/*if err add 2nd if equal 0*/
        $isdegButtonChecked = ($_POST['isdegButtonChecked'] === 'deg') ? 'rad' : 'deg';
     }
     else {
        $isdegButtonChecked = isset($_POST['isdegButtonChecked']) ? $_POST['isdegButtonChecked'] : 'deg';
    }




    //if we have one input to display 
    // if(isset($_POST['input']))//7
    // {
    //     $input = json_decode($_POST['input']);
    // }
        if($_POST['display'] && $_POST['display'][0] == '=' && is_numeric($_POST['expression']))
		{
			unset($_POST['display']);
			unset($_POST['input']);
		}
		else if( $_POST['display']&&$_POST['display'][0] == '=' &&  !(is_numeric($_POST['expression'])))
		{
			$_POST['display'] = substr($_POST['display'], 1);
		}
       
        foreach($_POST AS $key=>$value)
        { 
        //      echo 'key:' . $key . 'val:';
		//  echo $value;
            if($key=='equal')
            {
               $display= calculateInput($input);
                $input = [$display];
            $display = '=' . getInputAsString($input);
            }
            else if($key!='input' && $key!='isdegButtonChecked' && $key!='is2ndButtonChecked')
            {
                $input[] = $value;
               $display = getInputAsString($input);
            }
        }
    }

?>


<!--                                          HTML                                           -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator <i class="fa-solid fa-calculator"></i></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style/style.css">
</head> 
<body>
    <div class="container">
        <div class="buttons-container">
            <form method="POST" action="">
                <table>
                    <tbody>
                        <tr>
                            <th colspan="5">
                            <input type="text" name="display" class="display" value="<?php echo htmlspecialchars($display); ?>" <!--readonly-->>//current
                            <input type="text" name="input" value="<?php echo htmlspecialchars(json_encode($input)); ?>">
                            </th>
                        </tr>
                       
                        <tr> 
    <td class="hidden-column">
        <button type="submit" name="toggle" value="" class="hidden-button"<?php if ($isdegButtonChecked==='rad')
            echo 'disabled';?>>2nd</button>
<input type="hidden" name="is2ndButtonChecked" value="<?php echo htmlspecialchars($is2ndButtonChecked); ?>">
    </td>

    <td class="hidden-column">
        <button type="submit" name="deg-rad" <?php
// Check if the checkbox '2nd-checkbox' is set
$is2ndChecked = $is2ndButtonChecked;
$isdegChecked = $isdegButtonChecked;

// Determine the value based on the checkboxes
$value = $is2ndChecked==='0' ? ($isdegChecked==='deg' ? 'deg' : 'rad') : 'deg'; // Replace 'default_value' with your default value if needed
 ?> class="hidden-button"  <?php if($is2ndChecked==='1') echo 'disabled';?>><?php echo $isdegChecked?></button>
 <input type="hidden" name="isdegButtonChecked" value="<?php echo htmlspecialchars($isdegButtonChecked); ?>">
    </td>

    <td class="hidden-column">
    <button type="submit" name="expression" value="<?php echo ($is2ndButtonChecked === '0' ? ($isdegButtonChecked === 'rad' ? 'sin(deg2rad(' : 'sin(') : 'arcsin('); ?>" class="hidden-button"><?php echo ($is2ndButtonChecked === '0') ? 'sin' : 'sin<sup>-1</sup>'; ?></button>

    </td>
    <td class="hidden-column">
        <button type="submit" name="expression" value="<?php echo ($is2ndButtonChecked === '0' ? ($isdegButtonChecked === 'rad' ? 'cos(deg2rad(' : 'cos(') : 'arccos('); ?>"
        class="hidden-button"><?php echo ($is2ndButtonChecked === '0') ? 'cos' : 'cos<sup>-1</sup>'; ?></button>
    </td>
    <td class="hidden-column">
        <button type="submit" name="expression" value="<?php echo ($is2ndButtonChecked === '0' ? ($isdegButtonChecked === 'rad' ? 'tan(deg2rad(' : 'tan(') : 'arctan('); ?>" class="hidden-button"><?php echo ($is2ndButtonChecked === '0') ? 'tan' : 'tan<sup>-1</sup>'; ?></button>
    </td>
</tr>
<tr>
    <td class="hidden-column">
        <button type="submit" name="expression" value="^" class="hidden-button">x<sup>y</sup></button>
    </td>
    <td class="hidden-column">
        <button type="submit" name="expression" value="log(" class="hidden-button">lg</button>
    </td>
    <td class="hidden-column">
        <button type="submit" name="expression" value="ln(" class="hidden-button">ln</button>
    </td>
    <td class="hidden-column">
        <button type="submit" name="expression" value="&#40;" class="hidden-button">&#40;</button>
    </td>
    <td class="hidden-column">
        <button type="submit" name="expression" value="&#41;" class="hidden-button">&#41;</button>
    </td>
</tr>

<tr>
    <td class="hidden-column">
        <button type="submit" name="expression" value="&radic;" class="hidden-button">
            <i class="fa-solid fa-square-root-variable"></i>
        </button>
    </td>
    <td>
        <button type="submit" name="clear" value="clear" class="orange-button">
            <i class="fa-solid fa-c"></i>
        </button>
    </td>
    <td>
        <button type="submit" name="expression" value="del" class="orange-button">
            <i class="fa-solid fa-delete-left"></i>
        </button>
    </td>
    <td>
        <button type="submit" name="expression" value="\0025" class="orange-button">%</button>
    </td>
    <td>
        <button type="submit" name="expression" value="/" class="orange-button">
            <i class="fa-solid fa-divide"></i>
        </button>
    </td>
</tr>
<tr>
    <td class="hidden-column">
        <button type="submit" name="expression" value="!" class="hidden-button">
            <i class="fa-solid fa-xmark"></i><i class="fa-solid fa-exclamation"></i>
        </button>
    </td>
    <td>
        <button type="submit" name="expression" value="7" class="white-button">7</button>
    </td>
    <td>
        <button type="submit" name="expression" value="8" class="white-button">8</button>
    </td>
    <td>
        <button type="submit" name="expression" value="9" class="white-button">9</button>
    </td>
    <td>
        <button type="submit" name="expression" value="*" class="orange-button">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </td>
</tr>
<tr>
    <td class="hidden-column">
        <button type="submit" name="expression" value="1/" class="hidden-button">
            <sup>1</sup>/x
        </button>
    </td>
    <td>
        <button type="submit" name="expression" value="4" class="white-button">4</button>
    </td>
    <td>
        <button type="submit" name="expression" value="5" class="white-button">5</button>
    </td>
    <td>
        <button type="submit" name="expression" value="6" class="white-button">6</button>
    </td>
    <td>
        <button type="submit" name="expression" value="-" class="orange-button">
            <i class="fa-solid fa-minus"></i>
        </button>
    </td>
</tr>
<tr>
    <td class="hidden-column">
        <button type="submit" name="expression" value="3.14159265" class="hidden-button">
            <img src="icon/pi1.png" alt="pi" width="25px">
        </button>
    </td>
    <td>
        <button type="submit" name="expression" value="1" class="white-button">1</button>
    </td>
    <td>
        <button type="submit" name="expression" value="2" class="white-button">2</button>
    </td>
    <td>
        <button type="submit" name="expression" value="3" class="white-button">3</button>
    </td>
    <td>
        <button type="submit" name="expression" value="+" class="orange-button">
            <i class="fa-solid fa-plus"></i>
        </button>
    </td>
</tr>

                        <tr>
                            <td class="last-td">
                                <input type="checkbox" id="rotate-checkbox" >
                                <div class="icon-container">
                                    <div class="icon1"><i class="fa-solid fa-arrow-turn-down fa-rotate-270 fa-sm"></i></div>
                                    <div class="icon2"><i class="fa-regular fa-clone fa-sm"></i></div>
                                    <div class="icon3"><i class="fa-solid fa-arrow-turn-down fa-rotate-90 fa-sm"></i></div>
                                </div>
                            </td>
                            <td class="hidden-column"><button type="submit" value="\2091" class="white-button">e</button></td>
                            <td><button type="submit" value="0" name="expression" class="white-button">0</button></td>
                            <td><button type="submit" value="." name="expression" class="white-button">.</button></td>
                  <td><button name="equal" type="submit" value="=" class="orange-button" ><i class="fa-solid fa-equals"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
<script>
document.getElementById('rotate-checkbox').addEventListener('change', function() {
    const columns = document.querySelectorAll('.hidden-column');
    columns.forEach(column => {
        column.style.display = this.checked ? 'table-cell' : 'none'; // Toggle between hidden and visible
    });
});

</script>

