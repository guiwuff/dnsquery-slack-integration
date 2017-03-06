# Membangun integrasi DNS Query dengan Slack menggunakan PHP

### Tambahkan Konfigurasi Slash Command di Slack

- Masuk ke dalam Direktori Aplikasi Slack dan Search Slash Command. Add Configuration untuk Slash Commands, dalam hal ini yang akan kita register adalah command /dns
- Masuk ke bagian konfigurasi dan pelajari data yang akan dikirim dari Slack kepada url yang kita tentukan
- Sample Outgoing payload adalah sebagai berikut;

```
token=ZdGvnv3KUSXAB7GiUEsWTZMw
team_id=T0001
team_domain=example
channel_id=C2147483705
channel_name=test
user_id=U2147483697
user_name=Steve
command=/weather
text=94070
response_url=https://hooks.slack.com/commands/1234/5678
```

### Menyiapkan PHP End-point

End point dari sisi Aplikasi Server PHP adalah index.php yang memiliki fungsi sebagai berikut;

 * Melakukan pemeriksaan token untuk memastikan bahwa query dilakukan oleh tim slack milik kita
 * Menampung payload dari slack dengan menggunakan `$_POST `seperti `$_POST['command']`, `$_POST['text'] ` dan data lainnya yang masuk di dalam payload dengan catatan sebelumnya kita memilih metoda POST ketika mengirimkan payload
 * Merouting fungsi sesuai dengan sub command (text) yang dikirim dari slack, misalkan /dns whois namadomain.tld memiliki text whois namadomain.tld, maka dirouting ke fungsi yang melakukan whois dengan return value adalah hasil dari fungsi tersebut
 * Memeriksa apabila terjadi error, misalkan time out pada waktu fungsi dijalankan
 * Mengirimkan kembali hasil dari query atau error ke Slack

 ```php
 <?php
	// config tentukan value token yang akan dievaluasi, data ini diambil dari halaman konfigurasi app slack
 
	$payload_token ="token-dari-halaman-aplikasi";
	// Validasi token pengirim
 
 	if ($_POST['token'] != $payload_token){ 
	    $msg = "Token yang digunakan tidak valid, silahkan periksa kembali konfigurasi anda";
	    die($msg); // hentikan proses apabila token tidak valid
	    echo $msg; // kembalikan pesan ke Slack
	}
	
	// Ambil data slashcommand dan subcommand yang dibutuhkan dari payload
	$subcommand = $_POST['text'];
	
	
 ?>
 ```

### Struktur command dan subcommand

Sebelum kita dapat mempersiapkan fungsinya, terlebih dahulu kita rancang struktur command dan subcommand yang dapat dilakukan oleh anggota tim kita di slack.

#### Root

Root command dalam hal ini adalah `/dns` apabila terjadi request yang hanya berisikan root domain maka yang dikembalikan ke slack adalah help untuk root command tersebut;

```
/dns

Command membutuhkan subcommand dan parameter untuk dapat diproses
Penggunaan : /[command] [subcommand] <parameter>

* /dns whois <namadomain.tld | ip address>
* /dns dig host.namadomain.tld
* /dns nslookup

Selengkapnya dapat dipelajari melalui [List Command](http://garudaforce2it.webslices.co/php-dns-query/list-command.php)

```

#### Whois

Subcommand whois hanya membutuhkan satu parameter yaitu namadomain yang ingin diperiksa Whois Recordnya. Opsi lain belum dapat dilakukan melalui slashcommand ini

```
/dns whois 

Masukkan nama domain atau ip address yang ingin anda periksa Whois Recordnya
Penggunaan : /dns whois namadomain.tld atau /dns whois ip.add.yg.dicek

/dns whois bandar303.co

Whois record untuk bandar303.co

Domain Name:                                 BANDAR303.CO
Domain ID:                                   D123253788-CO
Sponsoring Registrar:                        NAMECHEAP, INC.
Sponsoring Registrar IANA ID:                1068
Registrar URL (registration services):       http://www.namecheap.com
Domain Status:                               clientTransferProhibited
Registrant ID:                               SP5QUGJ1FLPD5JOZ
Registrant Name:                             WhoisGuard Protected
Registrant Organization:                     WhoisGuard, Inc.
Registrant Address1:                         P.O. Box 0823-03411
Registrant City:                             Panama
Registrant State/Province:                   Panama
Registrant Postal Code:                      00000
Registrant Country:                          Panama
Registrant Country Code:                     PA
Registrant Phone Number:                     +507.8365503
Registrant Facsimile Number:                 +51.17057182
Registrant Email:                            e2a6810527c04777a856354d8f2151dc.protect@whoisguard.com
Administrative Contact ID:                   CMFICWOR4RA5GHL3
Administrative Contact Name:                 WhoisGuard Protected
Administrative Contact Organization:         WhoisGuard, Inc.
Administrative Contact Address1:             P.O. Box 0823-03411
Administrative Contact City:                 Panama
Administrative Contact State/Province:       Panama
Administrative Contact Postal Code:          00000
Administrative Contact Country:              Panama
Administrative Contact Country Code:         PA
Administrative Contact Phone Number:         +507.8365503
Administrative Contact Facsimile Number:     +51.17057182
Administrative Contact Email:                e2a6810527c04777a856354d8f2151dc.protect@whoisguard.com
Billing Contact ID:                          YEPV004LJ4NHRDK4
Billing Contact Name:                        WhoisGuard Protected
Billing Contact Organization:                WhoisGuard, Inc.
Billing Contact Address1:                    P.O. Box 0823-03411
Billing Contact City:                        Panama
Billing Contact State/Province:              Panama
Billing Contact Postal Code:                 00000
Billing Contact Country:                     Panama
Billing Contact Country Code:                PA
Billing Contact Phone Number:                +507.8365503
Billing Contact Facsimile Number:            +51.17057182
Billing Contact Email:                       e2a6810527c04777a856354d8f2151dc.protect@whoisguard.com
Technical Contact ID:                        I42PPTCGJFSRM5SR
Technical Contact Name:                      WhoisGuard Protected
Technical Contact Organization:              WhoisGuard, Inc.
Technical Contact Address1:                  P.O. Box 0823-03411
Technical Contact City:                      Panama
Technical Contact State/Province:            Panama
Technical Contact Postal Code:               00000
Technical Contact Country:                   Panama
Technical Contact Country Code:              PA
Technical Contact Phone Number:              +507.8365503
Technical Contact Facsimile Number:          +51.17057182
Technical Contact Email:                     e2a6810527c04777a856354d8f2151dc.protect@whoisguard.com
Name Server:                                 NS1.GARUDAHOSTING.NET
Name Server:                                 NS2.GARUDAHOSTING.NET
Created by Registrar:                        NAMECHEAP, INC.
Last Updated by Registrar:                   NAMECHEAP, INC.
Domain Registration Date:                    Thu Aug 11 19:43:00 GMT 2016
Domain Expiration Date:                      Thu Aug 10 23:59:59 GMT 2017
Domain Last Updated Date:                    Fri Aug 19 19:42:16 GMT 2016
DNSSEC:                                      false

>>>> Whois database was last updated on: Mon Mar 06 00:24:32 GMT 2017 <<<<
.CO Internet, S.A.S., the Administrator for .CO, has collected this
information for the WHOIS database through Accredited Registrars.
This information is provided to you for informational purposes only
and is designed to assist persons in determining contents of a domain
name registration record in the .CO Internet registry database. .CO
Internet makes this information available to you "as is" and does not
guarantee its accuracy.

By submitting a WHOIS query, you agree that you will use this data
only for lawful purposes and that, under no circumstances will you
use this data:  (1) to allow, enable, or otherwise support the transmission
of mass unsolicited, commercial advertising or solicitations via direct
mail, electronic mail, or by telephone; (2) in contravention of any
applicable data and privacy protection laws; or (3) to enable high volume,
automated,  electronic processes that apply to the registry (or its systems).
Compilation, repackaging, dissemination, or other use of the WHOIS
database in its entirety, or of a substantial portion thereof, is not allowed
without .CO Internet's prior written permission. .CO Internet reserves the
right to modify or change these conditions at any time without prior or
subsequent notification of any kind. By executing this query, in any manner
whatsoever, you agree to abide by these terms.  In some limited cases,
domains that might appear as available in whois might not actually be
available as they could be already registered and the whois not yet updated
and/or they could be part of the Restricted list. In this cases, performing a
check through your Registrar's (EPP check) will give you the actual status
of the domain. Additionally, domains currently or previously used as
extensions in 3rd level domains will not be available for registration in the
2nd level. For example, org.co,mil.co,edu.co,com.co,net.co,nom.co,arts.co,
firm.co,info.co,int.co,web.co,rec.co,co.co.

NOTE: FAILURE TO LOCATE A RECORD IN THE WHOIS DATABASE IS NOT
INDICATIVE OF THE AVAILABILITY OF A DOMAIN NAME.

All domain names are subject to certain additional domain name registration
rules. For details, please visit our site at www.cointernet.co <http://www.cointernet.co>.


```

### Memisahkan kumpulan fungsi ke file yang berbeda
 
Dalam hal ini kita akan membuat sebuah file class yang diberinama DNSQuery.php yang berisikan fungsi yang melayani query dari slack.

 
### TODO
- [ ] Melengkapi struktur command dan subcommand