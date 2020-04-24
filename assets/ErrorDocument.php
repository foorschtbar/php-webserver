<?php

$statuspara = $_SERVER["argv"][0];

$statuses = $statuses = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
    );
	
if($statuses[$statuspara] != "") {
	$statuscode = $statuspara ;
	$statusreason = $statuses[$statuspara];
} else {
	$statuscode = "";
	$statusreason = "Unkown Status Code \"".$statuspara."\"";
}
$title = "Status ".$statuscode." - ".$statusreason; 

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<title><?=$title?></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
		<style type="text/css">
			body {
				background-color: #eee;
			}

			.card {
				margin-top: 45px;
			}

			#status-card .status-code {
				font-size: 3rem;
				font-family: Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;
				margin-right: 0.5rem;
				display: inline;
			}

			#status-card .status-reason {
				font-size: 1.5rem;
			}	

			#status-card .status-icon {
				float:right;
				padding: 10px;
			}
			
			#status-card .text-muted {
				float:right;
			}	

			#status-card th { 
				width: 1px;
				white-space: nowrap;
			}	

			.table {
				margin-bottom: 0;
			}
	</style>
	</head>
	<body>
		<div class="container">
			<div id="status-card" class="card">
				<div class="card-header">
					<h1 class="status-code"><?=$statuscode?></h1><span class="status-reason"><?=$statusreason?></span><img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCIgdmlld0JveD0iMCAwIDYxMiA2MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDYxMiA2MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPGc+Cgk8ZyBpZD0iQXR0ZW50aW9uIj4KCQk8Zz4KCQkJPHBhdGggZD0iTTYwNS4yMTcsNTAxLjU2OGwtMjU1LTQ0MkMzNDEuMzk0LDQ0LjMwMiwzMjQuODg3LDM0LDMwNiwzNGMtMTguODg3LDAtMzUuMzk0LDEwLjMwMi00NC4yMTcsMjUuNTY4bC0yNTUsNDQyICAgICBDMi40ODIsNTA5LjA0OCwwLDUxNy43MzUsMCw1MjdjMCwyOC4xNTIsMjIuODQ4LDUxLDUxLDUxaDUxMGMyOC4xNTIsMCw1MS0yMi44NDgsNTEtNTEgICAgIEM2MTIsNTE3LjczNSw2MDkuNTM1LDUwOS4wNDgsNjA1LjIxNyw1MDEuNTY4eiBNNTAuOTY2LDUyNy4wNTFMMzA1Ljk0OSw4NUgzMDZsMC4wMzQsMC4wNTFMNTYxLDUyN0w1MC45NjYsNTI3LjA1MXogTTMwNiw0MDggICAgIGMtMTguNzY4LDAtMzQsMTUuMjMyLTM0LDM0YzAsMTguNzg1LDE1LjIxNSwzNCwzNCwzNHMzNC0xNS4yMzIsMzQtMzRTMzI0Ljc4NSw0MDgsMzA2LDQwOHogTTI3MiwyNTUgICAgIGMwLDEuOTM4LDAuMTcsMy44NTksMC40NzYsNS43MTJsMTYuNzQ1LDk5LjE0NUMyOTAuNTk4LDM2Ny44OTcsMjk3LjU4NSwzNzQsMzA2LDM3NHMxNS40MDItNi4xMDMsMTYuNzYyLTE0LjE0NGwxNi43NDUtOTkuMTQ1ICAgICBDMzM5LjgzLDI1OC44NTksMzQwLDI1Ni45MzgsMzQwLDI1NWMwLTE4Ljc2OC0xNS4yMTUtMzQtMzQtMzRDMjg3LjIzMiwyMjEsMjcyLDIzNi4yMzIsMjcyLDI1NXoiIGZpbGw9IiMwMDAwMDAiLz4KCQk8L2c+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" class="status-icon" />
				</div>
				<div class="card-block">
					<table class="table">
					  <tbody>
						<tr>
						  <th scope="row">Protocol</th>
						  <td><?= $_SERVER['SERVER_PROTOCOL']?></td>
						</tr>
						<tr>
						  <th scope="row">Request</th>
						  <td><?= $_SERVER['REQUEST_METHOD'].' '.$_SERVER['REQUEST_URI'] ?></td>
						</tr>
						<tr>
						  <th scope="row">Server</th>
						  <td><a href="//<?=$_SERVER["SERVER_NAME"]?>"><?=$_SERVER["SERVER_NAME"]?></a><?=$_SERVER['HTTP_X_FORWARDED_SERVER'] != "" ? " (".$_SERVER['HTTP_X_FORWARDED_SERVER'].")" : ""?></td>
						</tr>
						<tr>
						  <th scope="row">Port/TLS</th>
						  <td><?=$_SERVER["SERVER_PORT"]?>/<?= $_SERVER['HTTPS'] ? 'yes' : 'no' ?><?=$_SERVER['HTTP_X_FORWARDED_PROTO'] != "" ? " (".$_SERVER["HTTP_X_FORWARDED_PORT"]."/".($_SERVER['HTTP_X_FORWARDED_PROTO'] == "https" ? 'yes' : 'no').")" : "" ?>  </td>
						</tr>
						<tr>
						  <th scope="row">Client</th>
						  <td><?=$_SERVER["REMOTE_ADDR"]?><?=$_SERVER['HTTP_X_FORWARDED_FOR'] != "" ? " (".$_SERVER["HTTP_X_FORWARDED_FOR"].")" : "" ?>  </td>
						</tr>
						<tr>
						  <th scope="row">User Agent</th>
						  <td><?= $_SERVER['HTTP_USER_AGENT'] ?></td>
						</tr>
					  </tbody>
					</table>
				</div>
				<div class="card-footer">
					<small class="text-muted">powered by <a href="//<?=$_SERVER["SERVER_NAME"]?>"><?=$_SERVER["SERVER_NAME"]?></a></small>
				</div>
			</div>
		</div>
		
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

<!--
   - Unfortunately, Microsoft has added a clever new
   - "feature" to Internet Explorer. If the text of
   - an error's message is "too small", specifically
   - less than 512 bytes, Internet Explorer returns
   - its own error message. You can turn that off,
   - but it's pretty tricky to find switch called
   - "smart error messages". That means, of course,
   - that short error messages are censored by default.
   - IIS always returns error messages that are long
   - enough to make Internet Explorer happy. The
   - workaround is pretty simple: pad the error
   - message with a big comment like this to push it
   - over the five hundred and twelve bytes minimum.
   - Of course, that's exactly what you're reading
   - right now.
--> 
		
	</body>
</html>
