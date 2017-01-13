<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
<div>
<div style="font-size: 26px;font-weight: 700;letter-spacing: -0.02em;line-height: 32px;color: #41637e;font-family: sans-serif;text-align: center" align="center" id="emb-email-header"></div>
<p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Hey <?php echo $userName;?>,
</p> 
<p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px"> 
Your email id has been changed. For activate your account click on the link

<a here="http://fr8services.com.au/ci/admin/account_active/<?php echo $id;?>/<?php echo $token;?>">Click Here</a>
 <br/>
 Or
 <br>
 Run this "http://fr8services.com.au/ci/admin/account_active/<?php echo $id;?>/<?php echo $token;?>" url on the web.
</p>
</div>
</body>
</html>