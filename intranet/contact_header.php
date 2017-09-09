<div class="toptab">
<ul>
<li <?php if($ctab==0){ ?> style="background-color:#a9a9a9;" <?php } ?>><a href="customer.php?ctab=<?=encrypt('0',$Encrypt)?>&id=<?=encrypt($cid,$Encrypt)?>&e_action=<?=encrypt('edit',$Encrypt)?>&type=<?=encrypt($_GET['type'],$Encrypt)?>" style="text-decoration:none;">Basic Info</a></li>                                               
<li <?php if($ctab==1){ ?> style="background-color:#a9a9a9	;" <?php } ?>><a href="customer.php?ctab=<?=encrypt('1',$Encrypt)?>&id=<?=encrypt($cid,$Encrypt)?>&e_action=<?=encrypt('edit',$Encrypt)?>&type=<?=encrypt($_GET['type'],$Encrypt)?>" style="text-decoration:none;">Contact Person</a></li> 		 		
<li <?php if($ctab==2){ ?> style="background-color:#a9a9a9	;" <?php } ?>><a href="customer.php?ctab=<?=encrypt('2',$Encrypt)?>&id=<?=encrypt($cid,$Encrypt)?>&e_action=<?=encrypt('edit',$Encrypt)?>&type=<?=encrypt($_GET['type'],$Encrypt)?>" style="text-decoration:none;">Corres Notes</a></li>		 		             

<li <?php if($ctab==3){ ?> style="background-color:#a9a9a9	;" <?php } ?>><a href="customer.php?ctab=<?=encrypt('3',$Encrypt)?>&id=<?=encrypt($cid,$Encrypt)?>&e_action=<?=encrypt('edit',$Encrypt)?>&type=<?=encrypt($_GET['type'],$Encrypt)?>" style="text-decoration:none;">SQ</a></li>
<li <?php if($ctab==4){ ?> style="background-color:#a9a9a9	;" <?php } ?>><a href="customer.php?ctab=<?=encrypt('4',$Encrypt)?>&id=<?=encrypt($cid,$Encrypt)?>&e_action=<?=encrypt('edit',$Encrypt)?>&type=<?=encrypt($_GET['type'],$Encrypt)?>" style="text-decoration:none;">Pdts/Svcs Warranty History</a></li>	 		

</ul>
</div>