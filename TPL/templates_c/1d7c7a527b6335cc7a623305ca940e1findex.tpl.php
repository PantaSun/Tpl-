<html xmlns="http://WWW.W3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $this->_config['webname'];?></title>
</head>
    <body>
    <?php include 'test.php' ?>
    <?php /* 我是注释 */ ?>
    <?php echo $this->_vars['content']; ?>
    <?php echo $this->_vars['name']; ?>
    <?php if ($this->_vars['a']){?>
    2333333
    <?php }else{ ?>
    244444
    <?php }?>
    <br/>
    <?php foreach($this->_vars['array'] as $var=>$value){ ?>
        <?php echo $var ?>..<?php echo $value ?><br/>
    <?php } ?>
    </body>
</html>
