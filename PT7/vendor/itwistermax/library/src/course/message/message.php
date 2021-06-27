<?php
	namespace course\message;
	
    /**
     * Class for working with messages
     *
     * @author Maksim Mikhalkov
     * @version 1.0
     */
	class Message {
        /**
         * Echo user message
         * 
         * @param string $message - user message
        */
		public function printMessage(string $message='Hello, world!') {
			echo $message;
		}
	}