<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<button id="save-btn">Save Contact</button>


<script>
    var vCardsJS = require('vcards-js');

    //create a new vCard
    var vCard = vCardsJS();

    //set properties
    vCard.firstName = 'Eric';
    vCard.middleName = 'J';
    vCard.lastName = 'Nesser';
    vCard.organization = 'ACME Corporation';
    vCard.photo.attachFromUrl('https://avatars2.githubusercontent.com/u/5659221?v=3&s=460', 'JPEG');
    vCard.workPhone = '312-555-1212';
    vCard.birthday = new Date(1985, 0, 1);
    vCard.title = 'Software Developer';
    vCard.url = 'https://github.com/enesser';
    vCard.note = 'Notes on Eric';

    //save to file
    vCard.saveToFile('./eric-nesser.vcf');

    //get as formatted string
    console.log(vCard.getFormattedString());
    
</script>

</body>

</html>
