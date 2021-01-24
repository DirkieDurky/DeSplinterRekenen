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

#signIn {
    height: 435px;
}

.field#createAccount {
    height: 705px;
}

.backButton {
    font-family: "Torus Regular", serif;
    margin-top: 50px;
    color: white;
    text-align: center;
    position: absolute;
    left: 30%;
    transform: translate(-50%, 0%);
    width: 100px;
    height: 50px;
    border-radius: 16px;
    font-size: 17px;
    background-color: #333;
    border: none;
}

.backButton:hover {
    cursor: pointer;
    animation: hover 200ms;
    animation-fill-mode: forwards;
}

.title {
    font-size: 35px;
}

.underTitle {
    font-size: 20px;
    position: relative;
    transform: translate(-50%, -50%);
    left: 50%;
    width: 550px;
    margin-top: 35px;
    margin-bottom: 20px;
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

.type {
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
    width: 600px;
    margin-top: 0px;
    margin-bottom: 20px;
    opacity: 0;
    animation: show 200ms step-start 400ms;
    animation-fill-mode: forwards;
}

.error#signIn {
    top: 35px;
}

.error#createAccount {
    top: 20px;
}

.extend {
    animation:extend;
    animation-duration: 500ms;
    animation-fill-mode: forwards;
}

@keyframes extend{
    to {height: <?php session_start(); echo $_SESSION['extendHeight'];?>px;}
}

@keyframes show{
    to {opacity: 100}
}
.hyperlinks {
    font-family: "Segoe UI", serif;
    font-size: 16px;
    position: absolute;
    transform: translate(-50%, -50%);
    left: 50%;
    width: 500px;
    height: 50px;
    line-height: 50px;
    margin-top: 30px;
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
    position: absolute;
    top: 0;
    left: 0;
    width:100%;
    height: 56px;
    background-color: #212121;
}

.headerSelect {
    position: absolute;
    transform: translate(-50%, 0%);
    left: 50%;
    <?php if($_SESSION['appMan'] == TRUE){ echo "width: 1208px;";}?>
}

.headerSelect a{
    text-decoration: none;
    text-align: center;
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-bottom: none;
    border-top: none;
    display: inline-block;
    width: 300px;
    height: 56px;
    line-height: 56px;
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