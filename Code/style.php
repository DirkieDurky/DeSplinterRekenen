<?php
session_start();
require_once "DB_Connection.php";
?>
<style>
@font-face {
    font-family: Torus Regular;
    src: url("../Torus Regular.otf");
}

body#signIn {
    background-image: url('../RekensiteBackground.png');
}

.field {
    font-family: "Torus Regular", serif;
    margin-top: 5px;
    color: white;
    text-align: center;
    position: absolute;
    left: 50%;
    transform: translate(-50%, 0%);
    width: 600px;
    border-radius: 16px;
    font-size: 17px;
    background-color: #333;
}

.field#signIn {
    height: 435px;
}

.field#createAccount {
    height: 705px;
}

.backButton {
    font-family: "Torus Regular", serif;
    color: white;
    text-align: center;
    position: absolute;
    font-size: 17px;
    background-color: #333;
    border: none;
    text-decoration: none;
}

.backButton:link .backButton:visited {
    text-decoration: none;
}

.backButton:hover {
    cursor: pointer;
    animation: hover 200ms;
    animation-fill-mode: forwards;
    padding: 20px 40px;
}

.backButton#createAccount {
    transform: translate(-50%, 0%);
    left: 30%;
    margin-top: 50px;
    border-radius: 16px;
}

.backButton#assignmentEditor {
    bottom: 13px;
    left: 13px;
    padding: 13px;
    border-radius: 10px;
}

h1 {
    font-size: 35px;
}

.field [type="text"],[type="password"] {
    font-family: "Torus Regular", serif;
    font-size: 20px;
    position: relative;
    color: white;
    background-color: #222;
    border: none;
    border-radius: 7px;
    padding: 7px 10px;
    width: 20em;
    height: 2em;
    margin-bottom: 25px;
    margin-top: 5px;
}

.teacher {
    position: relative;
    font-size: 20px;
    display: block;
    width: 298px;
    height: 50px;
    line-height: 50px;
    float: left;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.submit {
    font-family: "Torus Regular", serif;
    color: white;
    font-size: 20px;
    height: 55px;
    width: 350px;
    position: relative;
    margin-top: 20px;
    background-color: red;
    border: none;
    border-radius: 10px;
}

.submit:hover {
    cursor: pointer;
    animation: hover 200ms;
    animation-fill-mode: forwards;
}

.error {
    color: red;
    font-size: 20px;
    position: relative;
    transform: translate(-50%, 0%);
    left: 50%;
    opacity: 0;
    animation: show 200ms step-start 400ms;
    animation-fill-mode: forwards;
}

@keyframes show{
    to {opacity: 100}
}

.error#signIn {
    top: 0;
    margin-top: -38px;
}

.error#createAccount {
    top: 20px;
    margin-top: 0;
}

.error#assignments {
    display: inline-block;
    margin-top: 0;
    opacity: 100;
    animation: none;
    font-size: 16px;
}

.extend {
    animation:extend;
    animation-duration: 500ms;
    animation-fill-mode: forwards;
}

@keyframes extend{
    to {height: <?= $_SESSION['extendHeight']?>px;}
}

.hyperlinks {
    font-family: "Segoe UI", serif;
    font-size: 16px;
    position: relative;
    transform: translate(-50%, -50%);
    display: block;
    left: 50%;
    width: 500px;
    margin-top: 25px;
    height: 40px;
    line-height: 40px;
}

.hyperlinks:link {
    text-decoration: none;
    color: rgb(255, 204, 34);
}

.hyperlinks:hover {
    text-decoration: underline;
}

.hyperlinks:visited {
    color: rgb(255, 204, 34);
}

@keyframes hover {
    from {
        filter: brightness(100%);
    }
    to {
        filter: brightness(70%);
    }
}

body#teacherSite {
    background-color: #181818;
}

.header {
    font-family: "Torus regular", serif;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 56px;
    background-color: #212121;
    z-index: 1;
}

<?php
    $sth = $pdo -> prepare("SELECT * FROM `accounts` WHERE id=?");
    $sth -> execute([$_SESSION['loggedID']]);
    $row = $sth -> fetch();
 ?>

.headerSelect {
    position: relative;
    display: inline-block;
    transform: translate(-50%, 0%);
    left: 50%;
}

.headerSelect a{
    text-decoration: none;
    text-align: center;
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-bottom: none;
    border-top: none;
    display: table-cell;
    width: 300px;
    height: 56px;
    vertical-align: middle;
    background-color: #212121;
}

.headerSelect a:hover{
   animation: hover 200ms;
   animation-fill-mode: forwards;
}

.headerSelect #selected{
    background-color: #3D3D3D;
}

.profPic {
    background-color: #4CAF50;
    font-size: 16px;
    border: none;
    cursor: pointer;
    position: absolute;
    top: 0;
    right: 0;
    width: 32px;
    height: 32px;
}

.dropdown {
    position: absolute;
    top: 12px;
    right: 20px;
    z-index: 2;
}

.dropdown-cont {
    display: none;
    position: absolute;
    top: 30px;
    right: 0;
    background-color: #181818;
    width: 160px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.dropdown-cont a {
    color: white;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-cont a:hover {
    background-color: #212121;
}

.dropdown:hover .dropdown-cont {display: block;}

.table {
    position: relative;
    text-align: center;
    transform: translate(-50%);
    left: 50%;
    border-collapse: collapse;
    width: 200px;
}

.collapsible th {
    height: 25px;
}

.table td {
    border: solid 1px;
}

.table td:not(.permsRadio)  {
    padding: 0 20px;
}

.table#students td:first-child, .table#usersInGroup td:first-child{
    border: none;
    padding: 0 3px;
}

#teachers {
    margin-top: 50px;
}

#students{
    margin-top: 20px;
}

#addToGroupForm {
    position: relative;
    transform: translate(-50%, -50%);
    left: 50%;
    margin-top:20px;
    display: inline-block;
}

.teacherField {
    font-family: "Torus regular", serif;
    position: absolute;
    transform: translate(-50%, 0);
    left: 50%;
    top: 0;
    margin-top:56px;
    background-color: #AAAAAA;
    display:block;
    padding: 20px 50px 0 50px;
    min-width: 500px;
    min-height: 500px;
}

.warning {
    font-family: "Torus regular", serif;
    font-size:20px;
    text-align: center;
    color: red;
    position: absolute;
    transform: translate(-50%, -50%);
    left: 50%;
    top: 50%;
    width: 400px;
    height: 200px;
    background-color: #212121;
    border-radius: 16px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.warning h3 {
    position:absolute;
    transform: translate(-50%, -50%);
    left: 50%;
    top: 40%;
    width: 380px;
}

#teacherSaveButton {
    font-family: "Torus Regular", serif;
    color: white;
    font-size: 20px;
    height: 55px;
    width: 350px;
    position: relative;
    margin-top: 50px;
    background-color: red;
    border: none;
    border-radius: 10px;
    transform: translate(-50%, -50%);
    left: 50%;
}

#teacherSaveButton:hover {
    cursor: pointer;
    animation: hover 200ms;
    animation-fill-mode: forwards;
}

.notification {
    font-family: "Torus regular", serif;
    position: fixed;
    z-index: 1;
    color: lime;
    text-align: center;
    right:2%;
    bottom:2%;
    background-color: #3d3d3d;
    width: 250px;
    min-height: 50px;
    opacity: 0;
    animation: notification 2500ms;
}

.notification#error {
    color: red;
}

@keyframes notification {
    from {opacity: 100}
    50% {opacity: 100}
    to {opacity: 0}
}

#addGroupButton {
    position: relative;
    transform: translate(-50%, -50%);
    left: 50%;
}

#addGroupForm {
    position: relative;
    display: inline-block;
    transform: translate(-50%, -50%);
    left: 50%;
    margin-bottom: 15px;
}

.collapsible {
    background-color: #eee;
    cursor: pointer;
    font-size: 15px;
    width: 90%;
    position: relative;
    transform: translate(-50%, 0);
    left: 50%;
    height: 30px;
    margin-top: 10px;
    border: none;
    outline: none;
}

#groups {
    margin-top: 20px;
    margin-bottom: 30px;
}

.groupDelete {
    position: absolute;
    left: 5px;
}

.collapsibleActive, .collapsible:hover {
    background-color: #ccc;
}

.collapsibleContent {
    display: none;
    max-height: 0;
    background-color: #f1f1f1;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    position: relative;
    width: 90%;
    left:50%;
    transform: translate(-50%);
}

.collapsibleContent#table {
    width: 100%;
}

#createAssignForm {
    position: relative;
    display: inline-block;
    transform: translate(-50%, -50%);
    left: 50%;
    margin-top: 30px;
    margin-bottom: 10px;
}

#continueIcon {
    position: absolute;
    right: 10px;
}

#buttonDelete {
    position: absolute;
    left: 10px;
}

.sidebar {
    font-family: "Torus regular", serif;
    position: fixed;
    background-color: #AAAAAA;
    height: 100%;
    width: 300px;
    top: 0;
    left: 0;
    z-index: 1;
}

#editAssignButtons {
    background-color: #eee;
    cursor: pointer;
    font-size: 15px;
    width: 90%;
    position: relative;
    transform: translate(-50%, 0);
    left: 50%;
    height: 30px;
    margin-top: 10px;
    border: none;
    outline: none;
}

#editAssignButtons:hover {
    background-color: #ccc;
}

#headOfSidebar {
    display: inline-block;
    position: relative;
    transform: translate(-50%);
    left: 50%;
}

#assignment {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 300px;
    right: 0;
}

#questionSelectButtons {
    position: relative;
    display: inline-block;
    margin-top: 50px;
    transform: translate(-50%);
    left: 50%;
}

#questionSelectButton {
    text-decoration: none;
    display: inline-block;
    width: 45px;
    height: 45px;
    background-color: #333;
    color: white;
    text-align: center;
    line-height: 45px;
    position: relative;
    z-index: 1;
}

#questionButtonsContainer {
    position: relative;
    display: inline-block;
}

#questionDeleteButton {
    display: inline-block;
    text-decoration: none;
    width: 30px;
    height: 30px;
    background-color: red;
    color: white;
    text-align: center;
    line-height: 30px;
    position: absolute;
    transform: translate(-50%, -100%);
    top: 100%;
    left: 50%;
    z-index: 0;
}

#questionButtonsContainer:hover #questionDeleteButton {
    animation: questionDeleteButtonShowUp 100ms;
    animation-fill-mode: forwards;
}

@keyframes questionDeleteButtonShowUp {
    to {transform: translate(-50%);}
}

#question {
    position: absolute;
    top: 150px;
    bottom: 0;
    width: 100%;
}

#deleteElements {
    text-decoration: none;
    display: inline-block;
    width: 25px;
    height: 25px;
    background-color: #333;
    color: white;
    text-align: center;
    line-height: 25px;
    position: relative;
    z-index: 1;
}
}

</style>