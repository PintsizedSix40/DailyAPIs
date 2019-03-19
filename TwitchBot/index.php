<?php
//This will be a script that runs a simple twitch bot

//We need this for it to run forever
set_time_limit(0);

//Next, lets take some code from the first bot

//////////CODE START

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

//////////CODE END

//Next, we have to check for messages. To do this, we will run a while(true) loop that constantly checks for new messages (sleeping in between of course)
//Also, I'm using a lot of QuaintShanty's code here (https://github.com/QuaintShanty/PHP-Twitch-IRC-Bot)
	while(true) {
		//Now let's grab out messages
			while($data = fgets($sock)) {
	    flush();
		//We have to split out message into an array to get the good parts
		$message = explode(' ', $data);
		//And now we check if we got pinged
				if($message[0] == "PING"){
        	fputs($sock, "PONG " . $message[1] . "\n");
	    }
		$rawcmd = explode(':', $message[3]);
		$rawcmd = preg_replace('~[.[:cntrl:][:space:]]~', '', $rawcmd);
		//And now all we have to do to get the command is:
		if($rawcmd[1] == "!ping"){
			sendMess("PONG!");
			//There we go! A (hopefully) working twitch bot in PHP! Don't forget that you have to run this from a command-line and NOT with a browser!
		}
			}
			//and sleep
			sleep(1);
	}
