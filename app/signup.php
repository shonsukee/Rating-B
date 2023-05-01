<?php
require("../libs/functions.php");

$csrf_token = generate_csrf_token();

require("../view/signup_view.php");