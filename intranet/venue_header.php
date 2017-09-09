<div class="toptab">
<ul>
<?php
echo $oid;
echo $oid;
echo $id;


?>
<li <?php if($ctab==0){ ?> style="background-color:#a9a9a9;" <?php } ?>><a href="trainingspace.php?ctab=<?=encrypt('0',$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&e_action=<?=encrypt('edit',$Encrypt)?>&type=<?=encrypt($_GET['type'],$Encrypt)?>" style="text-decoration:none;">Basic Info</a></li>                                               
<li <?php if($ctab==1){ ?> style="background-color:#a9a9a9	;" <?php } ?>><a href="trainingspace.php?ctab=<?=encrypt('1',$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&e_action=<?=encrypt('edit',$Encrypt)?>&type=<?=encrypt($_GET['type'],$Encrypt)?>" style="text-decoration:none;">Training Venue Profile</a></li> 		 		
<li <?php if($ctab==2){ ?> style="background-color:#a9a9a9	;" <?php } ?>><a href="trainingspace.php?ctab=<?=encrypt('2',$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&e_action=<?=encrypt('edit',$Encrypt)?>&type=<?=encrypt($_GET['type'],$Encrypt)?>" style="text-decoration:none;">Performance</a></li>	 		             

<li <?php if($ctab==3){ ?> style="background-color:#a9a9a9	;" <?php } ?>><a href="trainingspace.php?ctab=<?=encrypt('3',$Encrypt)?>&id=<?=encrypt($id,$Encrypt)?>&e_action=<?=encrypt('edit',$Encrypt)?>&type=<?=encrypt($_GET['type'],$Encrypt)?>" style="text-decoration:none;">Venue Schedule</a></li>
	 		

</ul>
</div>