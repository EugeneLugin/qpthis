<?php 
    require("config.php");     
	
	$query = " 
            SELECT 
                *
            FROM item
            WHERE 
                uuid = :uuid
        "; 
	$query_params = array( 
		':uuid' => $_GET['id']
	); 
	 
	try{ 
		$stmt = $db->prepare($query); 
		$result = $stmt->execute($query_params); 
	} 
	catch(PDOException $ex){ die("Невозможно выполнить запрос: " . $ex->getMessage()); } 
	
	$item = $stmt->fetch(); 
    if(!$item){
		die("Нет такого товара");
	}
?>
<?php $uid = uniqid();?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Форма заказа</title>
<style type="text/css">
<!--
.button {
	BORDER-TOP-WIDTH: 0px; FONT-WEIGHT: bold; BORDER-LEFT-WIDTH: 0px; FONT-SIZE: 9pt; BORDER-BOTTOM-WIDTH: 0px; COLOR: white; FONT-FAMILY: Arial; BACKGROUND-COLOR:#003366; BORDER-RIGHT-WIDTH: 0px
}
.input {
	BORDER-RIGHT: #7F9DB9 1px solid; BORDER-TOP: #7F9DB9 1px solid; BORDER-LEFT: #7F9DB9 1px solid; WIDTH: 220px; BORDER-BOTTOM: #7F9DB9 1px solid
}
.input2 {
	BORDER-RIGHT: #7F9DB9 1px solid; BORDER-TOP: #7F9DB9 1px solid; BORDER-LEFT: #7F9DB9 1px solid; WIDTH: 40px; BORDER-BOTTOM: #7F9DB9 1px solid
}
.cod {
	BORDER-RIGHT: #7F9DB9 1px solid; BORDER-TOP: #7F9DB9 1px solid; BORDER-LEFT: #7F9DB9 1px solid; WIDTH: 40px; BORDER-BOTTOM: #7F9DB9 1px solid
}
.phone {
	BORDER-RIGHT: #7F9DB9 1px solid; BORDER-TOP: #7F9DB9 1px solid; BORDER-LEFT: #7F9DB9 1px solid; WIDTH: 117px; BORDER-BOTTOM: #7F9DB9 1px solid
}
.small {font-size: 9px;}
.small2 {font-size: 11px;}

-->
</style>
</head>
<body style="background:none">
<?php if ($item['yandexmetric']) { ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter<?php echo $item['yandexmetric'] ?> = new Ya.Metrika({id:<?php echo $item['yandexmetric'] ?>,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<!-- /Yandex.Metrika counter -->
<?php } ?>

<FORM action="<?=$api_url?>/do_order.php" method=post name="order_form_13" target="_parent" onsubmit="return checkForm_13(this)">
	<input type='hidden' id="item_uuid" name='id' value='<?php echo $item['uuid']?>'>
	<TABLE style="FONT-SIZE: 10pt; FONT-FAMILY: Arial" cellSpacing=2 cellPadding=2 width="98%" align=center border=0>
		<TBODY>
        <TR>
			<TD align=right width="50%"><b>Фамилия*</b></TD>
			<TD><INPUT name="fam" class=input value="" maxlength=20></TD></TR>
        <TR>
			<TD align=right width="50%"><b>Имя*</b></TD>
			<TD><INPUT name="name" class=input value="" maxlength=50></TD>
		</TR>
		<TR>
			<TD align=right valign="top" style="padding-top:5px;"><b>Телефон мобильный*</b> +38</TD>
			<TD>
				<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><input name="phone" class="phone" id="phone_mob_<?php echo $uid;?>" maxlength=14 placeholder='(___)___-__-__'></td>
				</tr>
				</table>
			</TD>
		</TR>
		<TR>
		   <TD height="10" colSpan=2></TD>
   	    </TR>
        <TR>
			<TD align=right width="50%"><b>Область</b></TD>
			<TD><INPUT name="area" class=input value="" maxlength="100"></TD></TR>
        <TR>
			<TD align=right width="50%"><b>Город*</b></TD>
			<TD><INPUT name="city" class=input value="" maxlength="50"></TD></TR>
        <TR>
			<TD align=right width="50%"><b>Отделение Новой Почты или домашний адрес (улица, дом)</b></TD>
			<TD><TEXTAREA class=input name="address" rows="2" cols="20"></TEXTAREA></TD></TR>       
        <TR>
			<TD height="10" colSpan=2></TD>
		</TR>
        <TR>
			<TD align=right width="50%"><b>E-mail</b></TD>
			<TD><INPUT name="email" class=input value="" maxlength=50></TD>
		</TR>		  	
		<TR>
          <TD height="10" colSpan=2>          </TD>
		</TR>
		<?php if ($item['param1']) { ?>
		<TR>
			<TD align=right width="50%"><b><?php echo $item['param1_name'] ?></b></TD>
			<TD>
				<select name='param1'>
					<?php foreach (preg_split('/;/',$item['param1']) as $idx => $param_val) { ?>
						<option value='<?php echo $param_val;?>'<?php if ($idx == 0) {echo " selected='selected'";}?>><?php echo $param_val ?></option>
					<?php } ?>	
				</select>
			</TD>
		</TR>
		<?php } ?>
		<?php if ($item['param2']) { ?>
		<TR>
			<TD align=right width="50%"><b><?php echo $item['param2_name'] ?></b></TD>
			<TD>
				<select name='param2'>
					<?php foreach (preg_split('/;/',$item['param2']) as $idx => $param_val) { ?>
						<option value='<?php echo $param_val;?>'<?php if ($idx == 0) {echo " selected='selected'";}?>><?php echo $param_val ?></option>
					<?php } ?>	
				</select>
			</TD>
		</TR>
		<?php } ?>
        <TR>
          <TD align=right width="50%"><b>Количество*</b></TD>		  
          <TD><INPUT type="number" min="1" name="count" class=input2 value="1" maxlength=6>&nbsp;<INPUT class="button" type="submit" value="Оформить заказ"></TD>
		</TR>
</TBODY></TABLE>
      <CENTER>
</CENTER></FORM>

<script type='text/javascript'>
function checkForm_13(f)
{
 if((f.fam.value=="")||(f.name.value=="")||(f.city.value==""))
 {
  alert("Вы указали не всю информацию!!! Все поля отмеченные знаком '*', обязательны для заполнения!");
  return false;
 }

 if(!f.count.value.match(/^[1-9]{1}[0-9]*$/i))
 {
	 alert ("Укажите корректное количество заказываемого товара!");
	 f.count.focus();
	 return false;
 }

 if(f.email.value!='' && !f.email.value.match(/^[\w]{1}[\w\.\-_]*@[\w]{1}[\w\-_\.]*\.[\w]{2,4}$/i))
 {
	 alert ("Введите корректно Ваш E-Mail адрес!");
	 f.email.focus();
	 return false;
 }
  
 if(!f.phone.value.match(/^\(0\d\d\)\d\d\d-\d\d-\d\d$/i))
 {
	 alert ("Введите корректно Ваш номер телефона!");
	 f.phone.focus();
	 return false;
 }

<?php if ($item['yandexmetric']) { ?>yaCounter<?php echo $item['yandexmetric'] ?>.reachGoal('<?php echo $item['yandexgoal'] ?>');<?php } ?>
return true; 
}
// - JavaScript - -->

(function() {
    function jQueryLoad(js, css, cb) {
        function getScript(url, cb, error) {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = url;
            script.onload = cb;
            script.onerror = error;
            document.head.appendChild(script);
        }

        function addcss(css) {
            var head = document.getElementsByTagName('head')[0];
            var s = document.createElement('link');
            s.rel = 'stylesheet';
            s.type = 'text/css';
            s.href = css;
            head.appendChild(s);
        }

        function _err(e) {
            if (_loaded) {
                jQuery.noConflict(true);
            }
        }

        function _cb(e) {
            if (e != null) {
                _loaded = true;
            }
            if (js.length > 0) {
                getScript(js.shift(), _cb, _err);
            } else {
                cb(jQuery.noConflict(true));
            }
        }

        var _loaded = false;

        for (var i = 0; i < css.length; i++) {
            addcss(css[i]);
        }

        _cb(null);
    }

    function entryPoint(jQuery) {
        (function(e){function t(){var e=document.createElement("input"),t="onpaste";return e.setAttribute(t,""),"function"==typeof e[t]?"paste":"input"}var n,a=t()+".mask",r=navigator.userAgent,i=/iphone/i.test(r),o=/android/i.test(r);e.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"},dataName:"rawMaskFn",placeholder:"_"},e.fn.extend({caret:function(e,t){var n;if(0!==this.length&&!this.is(":hidden"))return"number"==typeof e?(t="number"==typeof t?t:e,this.each(function(){this.setSelectionRange?this.setSelectionRange(e,t):this.createTextRange&&(n=this.createTextRange(),n.collapse(!0),n.moveEnd("character",t),n.moveStart("character",e),n.select())})):(this[0].setSelectionRange?(e=this[0].selectionStart,t=this[0].selectionEnd):document.selection&&document.selection.createRange&&(n=document.selection.createRange(),e=0-n.duplicate().moveStart("character",-1e5),t=e+n.text.length),{begin:e,end:t})},unmask:function(){return this.trigger("unmask")},mask:function(t,r){var c,l,s,u,f,h;return!t&&this.length>0?(c=e(this[0]),c.data(e.mask.dataName)()):(r=e.extend({placeholder:e.mask.placeholder,completed:null},r),l=e.mask.definitions,s=[],u=h=t.length,f=null,e.each(t.split(""),function(e,t){"?"==t?(h--,u=e):l[t]?(s.push(RegExp(l[t])),null===f&&(f=s.length-1)):s.push(null)}),this.trigger("unmask").each(function(){function c(e){for(;h>++e&&!s[e];);return e}function d(e){for(;--e>=0&&!s[e];);return e}function m(e,t){var n,a;if(!(0>e)){for(n=e,a=c(t);h>n;n++)if(s[n]){if(!(h>a&&s[n].test(R[a])))break;R[n]=R[a],R[a]=r.placeholder,a=c(a)}b(),x.caret(Math.max(f,e))}}function p(e){var t,n,a,i;for(t=e,n=r.placeholder;h>t;t++)if(s[t]){if(a=c(t),i=R[t],R[t]=n,!(h>a&&s[a].test(i)))break;n=i}}function g(e){var t,n,a,r=e.which;8===r||46===r||i&&127===r?(t=x.caret(),n=t.begin,a=t.end,0===a-n&&(n=46!==r?d(n):a=c(n-1),a=46===r?c(a):a),k(n,a),m(n,a-1),e.preventDefault()):27==r&&(x.val(S),x.caret(0,y()),e.preventDefault())}function v(t){var n,a,i,l=t.which,u=x.caret();t.ctrlKey||t.altKey||t.metaKey||32>l||l&&(0!==u.end-u.begin&&(k(u.begin,u.end),m(u.begin,u.end-1)),n=c(u.begin-1),h>n&&(a=String.fromCharCode(l),s[n].test(a)&&(p(n),R[n]=a,b(),i=c(n),o?setTimeout(e.proxy(e.fn.caret,x,i),0):x.caret(i),r.completed&&i>=h&&r.completed.call(x))),t.preventDefault())}function k(e,t){var n;for(n=e;t>n&&h>n;n++)s[n]&&(R[n]=r.placeholder)}function b(){x.val(R.join(""))}function y(e){var t,n,a=x.val(),i=-1;for(t=0,pos=0;h>t;t++)if(s[t]){for(R[t]=r.placeholder;pos++<a.length;)if(n=a.charAt(pos-1),s[t].test(n)){R[t]=n,i=t;break}if(pos>a.length)break}else R[t]===a.charAt(pos)&&t!==u&&(pos++,i=t);return e?b():u>i+1?(x.val(""),k(0,h)):(b(),x.val(x.val().substring(0,i+1))),u?t:f}var x=e(this),R=e.map(t.split(""),function(e){return"?"!=e?l[e]?r.placeholder:e:void 0}),S=x.val();x.data(e.mask.dataName,function(){return e.map(R,function(e,t){return s[t]&&e!=r.placeholder?e:null}).join("")}),x.attr("readonly")||x.one("unmask",function(){x.unbind(".mask").removeData(e.mask.dataName)}).bind("focus.mask",function(){clearTimeout(n);var e;S=x.val(),e=y(),n=setTimeout(function(){b(),e==t.length?x.caret(0,e):x.caret(e)},10)}).bind("blur.mask",function(){y(),x.val()!=S&&x.change()}).bind("keydown.mask",g).bind("keypress.mask",v).bind(a,function(){setTimeout(function(){var e=y(!0);x.caret(e),r.completed&&e==x.val().length&&r.completed.call(x)},0)}),y()}))}})})(jQuery);

        window.qp_jQ = jQuery;

        qp_jQ('#phone_mob_<?php echo $uid;?>').mask("(999)999-99-99");
    }

    jQueryLoad([
        '//code.jquery.com/jquery-1.10.1.min.js',
    ], [], entryPoint);
})();

</script>    
    
</body>
</html>

