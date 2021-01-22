<style>
@font-face {
    font-family: Torus Regular;
    src: url("../Torus Regular.otf");
}

body {
    background-image: url('../RekensiteBackground.png');
}

.field {
    font-family: "Torus Regular";
    margin-top: 25px;
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

#createAccount {
    height: 738px;
}

.backButton {
    font-family: "Torus Regular";
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

.extend {
    animation:extend;
    animation-duration: 500ms;
    animation-fill-mode: forwards;
}

@keyframes extend{
    to {height: <?php session_start(); echo $_SESSION['extendHeight'];?>px;}
}

#forgotpass {
    height: 350px;
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
    margin-top: 40px;
    margin-bottom: 10px;
}

.input {
    font-family: "Torus Regular";
    font-size: 20px;
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

.submit {
    font-family: "Torus Regular";
    color: white;
    font-size: 20px;
    height: 55px;
    width: 350px;
    position: absolute;
    transform: translate(-50%, -50%);
    margin-top: 35px;
    left: 50%;
    background-color: red;
    border: none;
    border-radius: 10px;
}

.submit:hover {
    cursor: pointer;
    animation: hover 200ms;
    animation-fill-mode: forwards;
}

.signinlinks {
    font-family: "Segoe UI";
    font-size: 16px;
    position: absolute;
    transform: translate(-50%, -50%);
    left: 50%;
    width: 500px;
    margin-top: 100px;
}

.error {
    color: red;
    font-size: 20px;
    position: relative;
    transform: translate(-50%, 0%);
    left: 50%;
    width: 600px;
    margin-top: 30px;
    margin-bottom: 20px;
    opacity: 0;
    animation: show 200ms step-start 400ms;
    animation-fill-mode: forwards;
}

.error#signIn {
    top: 100px;
}

.error#createAccount {
    top: 50px;
}

@keyframes show{
    to {opacity: 100}
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
        filter: brightness(85%);
    }
}