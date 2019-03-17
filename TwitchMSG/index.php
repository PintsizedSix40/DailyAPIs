<?php

//Checks is user supplied msg argument (this will be '?msg=something', located at the end of the url)
//isset(var) checks if the variable is set, and $_GET['param'] gets the parameter from the url.
//die() kills the application, so if the user did not supply a msg arg, it will die
if(!isset($_GET['msg'])){
	die();
}
//Get message to send
$msg = $_GET['msg'];

//Define variables needed to signin
$pass = ''; //oauth from twitchapps.com/tmi. Looks something like oauth:jhfhsjguu768yshjgh
$nick = ''; //the bot's username
$channel = '#'.''; //the channel to be connected to, starting with a #. MUST BE LOWERCASED!!

//Open bot socket (connects to twitch's chat server)
$sock = fsockopen('irc.chat.twitch.tv' /* Twitch's Chat Server */, 6667 /* Port of server */)

//Create a function to send data
function send($mess){
	//fputs sends data through the socket (to twitch), and accepts a message as well (we add /r/n to end the line)
	fputs($sock, $mess."\r\n");
}

//create a function to send chat messages messages
function sendMess($mess){
	//PRIVMSG is a command, and it sends a message to a channel (or user). If the channel name is #pintsizedsix40 and the message is hi, it will end up looking like 'PRIVMSG #pintsizedsix40 :hi'. This will send the message hi to the channel #pintsizedsix40.
	send("PRIVMSG ".$channel." :".$mess);
}

//Now, let's authenticate! We first send the password with the command 'PASS oauth', then we send the username with 'NICK name'
send('PASS '.$pass);
send('NICK '.$nick);

//Finally, let's join a channel with the JOIN command
send('JOIN '.$channel);

//Now we can send our message!
sendMess($msg);

//Finally, close the connection
socket_close($sock);

//WARNING: If this API receives too many requests, some may not go through. A bot that actively listens for requests and sends them as they come in would be better