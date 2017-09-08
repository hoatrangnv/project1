<div>
    Hello {{ $name }}!
    Please active your account !
    <a href="<?php echo URL::to('/')."/active/".$code."/".$email?>"></a>
</div>