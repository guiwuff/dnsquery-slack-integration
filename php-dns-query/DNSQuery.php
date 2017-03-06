<?php
    class DNSQuery {
        var $text = null;
        var $subcommand = null;
        var $param = null;
        var $commandstatus = null;
        var $returnmsg = null;
        
        // construct object menggunakan subcommand
        function __construct($text) {	

            $this->text = strtolower($text);            
            $this->split_text();
            
            switch ($this->subcommand) {
                case 'whois':
                    $this->do_whois();
                    break;
                
                default:
                    # code...
                    break;
            }	           
		}		
 
        // set subcommand yang ingin diproses
        function set_text($new_text){
            $this->text = $new_text;
        }
        // ambil subcommand yang digunakan di object ini_alter

        function get_text(){
            return $this->text;
        }

        function get_returnmsg(){
            return $this->returnmsg;
        }

        function get_commandstatus(){
            return $this->commandstatus;
        }

        function split_text(){
            // explode string by spaces
            $splittext = explode(" ", $this->text);
            
            // apabila hasil explode lebih dari dua
            if( count($splittext) > 2){
                $this->commandstatus = 0;
                $this->returnmsg = static_msg('ErrParam');
            } elseif ( count($splittext) < 2){
                $this->commandstatus = 1;
                $this->returnmsg = static_msg('RootCommand');
            } else {
                $this->subcommand = $splittext[0];
                $this->param= $splittext[1];
            }
        }

        function static_msg($title){
            // Fungsi ini mengembalikan string pesan berdasarkan argumen $title
            $msg['RootCommand']['whois'] = 'Masukkan nama domain atau ip address yang ingin anda periksa Whois Recordnya\n';
            $msg['RootCommand']['whois'] .= 'Penggunaan : /dns whois namadomain.tld atau /dns whois ip.add.yg.dicek';
            $msg['ErrParam'] = 'Penulisan command masih belum tepat';

            switch ($title) {
                case 'RootCommand':
                    if($this->subcommand == 'whois'){
                        return $msg['RootCommand']['whois'];
                    } elseif ($this->subcommand == 'dig') {
                    
                    } elseif ($this->subcommand == 'nslookup') {
                    
                    }
                    break;
                case 'ErrParam':
                    return $msg['ErrParam'];
                    break;
                default:
                    # code...
                    break;
            }
        }

        function do_whois(){
            // Open a Socket connection to our WHOIS server
            $fp = fsockopen("whois.domain.com", 43);

            // The data we're sending
            $out = $this->param."\r\n";

            // Send the data
            fwrite($fp, $out);

            // Listen for data and "append" all the bits of information to 
            // our result variable until the data stream is finished
            // Simple: "give me all the data and tell me when you've reached the end"
            while (!feof($fp)) {
                $whois .= fgets($fp, 128);
            }

            $this->commandstatus = 1;
            $this->returnmsg = json_encode(array(
                "content-type"  =>  "application/json",
                "title" => "Whois Record ".$this->param,
                "text" => $whois
            ),JSON_UNESCAPED_SLASHES);


            // Close the Socket Connection
            fclose($fp);
        }

        function process(){
  

        }

    }
?>