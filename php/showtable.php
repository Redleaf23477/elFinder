
<pre>
<?php
$dbconf = json_decode($_POST["dbconf"], true);
$dsn = $dbconf['sql'] . ':dbname=' . $dbconf['database'] . ';';
$user = $dbconf['user'];
$pass = $dbconf['pass'];
$table = $dbconf['tablename'];
$something = '{}';

try {
    $dbh = new PDO($dsn, $user, $pass);
    $qry = $dbh->prepare("select * from $table");
    $qry->execute();
    $res = $qry->fetchAll(PDO::FETCH_CLASS);
    $something = json_encode($res);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage(); 
}
?>
</pre>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" rel="stylesheet">
    <title>Showtable</title>
</head>
<body>
<div id="container"></div>
</body>
<script>

function getHotColumns(colHeader) {
    var res = [];
    for (var i = 0; i < colHeader.length; i++) {
        res.push({data: colHeader[i]});
    }
    return res;
}

const data = JSON.parse('<?php echo $something; ?>');
const colHeader = Object.keys(data[0]);
var container = document.getElementById("container");
var tb = new Handsontable(container, {
    data : data,
    rowHeaders: true,
    colHeaders: colHeader,
    columns: getHotColumns(colHeader),
    licenseKey: 'non-commercial-and-evaluation'
});

</script>
</html>