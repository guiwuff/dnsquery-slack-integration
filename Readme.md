#DNS Query Slack Integration

> Slack integration with a PHP Web Application provides tools to do DNS Query such as : whois and dig via slack slash command

### Query
- [ ] Whois : Check specific domain resgistration lookup
- [ ] Dig : Check entry from DNS
- [ ] Nslookup :

### Slack Slash Command

```
/dns whois domain.tld
/dns dig hostname.domain.tld
/dns nslookup domain.tld
```

### Results
- Raw

```
Your Query /dns nslookup webslices.co returns the following results

Server:		8.8.8.8
Address:	8.8.8.8#53

Non-authoritative answer:
Name:	webslices.co
Address: 104.18.35.119
Name:	webslices.co
Address: 104.18.34.119

type /dns nslookup to view the available sub commands
```

- Styled

### PHP Application