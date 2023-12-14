# K-Digital Training Information Security 3rd Assignment 3

### Overview

**Subject: 서버 내 취약점 공격 및 방어**

**Environment**

```
OS: Kali Linux 6.3.0(VMware)
Language: PHP, HTML
Server: Apache
DB: MySQL
Tools: Burp Suite
```

1. Source Code Link<a href="#1-source-code-link"><sup>[1]</sup></a>

2. Implementation<a href="#2-implementation"><sup>[2]</sup></a>

3. Wrap Up<a href="#3-wrap-up"><sup>[3]</sup></a>

4. WIP<a href="#4-wip"><sup>[4]</sup></a>

5. Review<a href="#5-review"><sup>[5]</sup></a>

6. Ref Links<a href="#6-ref-links"><sup>[6]</sup></a>

---

#### 1. Source Code Link

[Link - KDT_IS3_Assignment2](https://github.com/ymiwm/KDT_IS3_Assignment3)

---

#### 2. Implementation

앞서 수행한 [Assignment2](https://github.com/ymiwm/KDT_IS3_Assignment2) Web Application의 취약점 분석

>**Succeed**: 취약점 있음, 공격 성공  
>**Failed**: 취약점 없음, 공격 실패

0. **Assets**
    1. Account information in '*Member*' table
    2. Data in '*Board*' table
    3. Directory and file information

1. **SQL injection - Failed**
    - **수행**: PDO로 인해 다른 injection 방법 수행.  
    ```--secure-file-priv``` 설정을 ```null```로 바꾼 후 ```load_file()```을 이용해 *sqli.txt*을 불러오기 시도.  
    ( + )```(select '<?=`$_GET[var]`;?>f' into outfile '/var/www/html/hack.php')```

    - **결과**: SQL injection 이전에 MySQL server에 직접 query를 보냈을 때 결과값이 null로 반환되어 파일 불러오기 실패.
    ![SQL 0](/img/SQL_Injection/SQLI%200.png)

    - **방어**: PDO의 prepare(pstmt)과 parameter binding(bindParam) 사용과 필터링을 추가해주면 더 견고한 방어가 가능할 것으로 보임

2. **Cross-Site Scripting(XSS) - Succeed**  
    - **수행**: *Write* 작업에서 보내지는 ```content``` 에 payload를 입력하여 결과 확인.

    - **수행**: ```alert``` 동작, 서버 내 img파일에도 접근하여 출력 가능.
    
    - ```<script> alert(1) </script>```
    ![XSS 0](/img/XSS/XSS%200.png)
    ![XSS 1](/img/XSS/XSS%201.png)
    - ```<img src='img/f.png'>```
    ![XSS 2](/img/XSS/XSS%202.png)
    ![XSS 3](/img/XSS/XSS%203.png)

    - **방어**: 시스템적인 방어가 불가능함으로 문자 필터링으로 방어.
    (*script*를 필터링 하거나, htmlentities 함수 사용.)

3. **Session prediction & Session fixation - Failed**
    - **수행**: ```<script>alert(document.cookie)</script>```를 *index.php*에 hard coding하여 확인.

    - **결과**: 검색 결과 MD5 해쉬를  
        - IP address of the client
        - Current time
        - PHP Linear Congruence Generator - a pseudo random number generator (PRNG)
        - OS-specific random source - if the OS has a random source available (e.g. /dev/urandom)

    위와 같은 요소와 함께 생성한다고 함.
    이로써 Session prediction은 해결되었지만, 다른 시간에 로그아웃 후 로그인 해본 결과 ```session_destroy()```가 되어 id가 바뀔 것이라 예상하였으나 같은 id가 주어짐. 다만, 웹 브라우저를 껐다키는 경우 값이 바뀌어 Session fixation 또한 해당되지 않는 것으로 보임.

    - 로그인 후 
    ![SESSION 0](/img/session/Session%200.png)
    - 로그아웃 후 다시 로그인
    ![SESSION 1](/img/session/Session%201.png)
    - 웹 브라우저 종료 후 다시 로그인
    ![SESSION 2](/img/session/Session%202.png)

    - **방어**: 해당 없음

4. **Insufficient authorization - Failed but vulnerable**
    - **수행**: *Write* 동작 시 *POST* 방식으로 보내지는 ```$id``` 값에서 session에 대한 검증이 없으므로 접근 권한을 무시하고 다른 작성자로 위장할 수 있음. 다만, *POST*방식에 ```input```으로 주어지는 *Author*부가 고정되어있어 방법 찾지 못함.

    - **결과**: 없음(밑의 이미지는 수행부의 내용을 확인시키기 위함)
    ![Insufficient Authorization 0](/img/insufficient%20authorization/Insufficient%20Authorization%200.png)
    ![Insufficient Authorization 1](/img/insufficient%20authorization/Insufficient%20Authorization%201.png)

    - **방어**: ```session``` id를 확인하여 인가 절차 추가

5. **Sending plain data - Succeed**
    - **수행**: **Burp Suite** 를 사용하여 *Request*, *Response* 데이터 확인

    - **결과**: 데이터 전송 과정에 session id, raw data가 그대로 드러남.
    Man-In-The-Middle 등의 공격이 가능할 것으로 보임.
    ![Sending plain data 0](/img/sending%20plain%20data/Sending%20Plain%20Data%200.png)
    ![Sending plain data 1](/img/sending%20plain%20data/Sending%20Plain%20Data%201.png)
    ![Sending plain data 2](/img/sending%20plain%20data/Sending%20Plain%20Data%202.png)
    ![Sending plain data 3](/img/sending%20plain%20data/Sending%20Plain%20Data%203.png)

    - **방어**: 정보 전달 시 Encrytion, Hashing을 적용

6. **Directory indexing & Directory traversal - Failed**
    - **수행**:
        - Directory indexing  
        URL에 경로를 서버 내 디렉토리로 설정.
        - Directory traversal  
        ```../"root에서 접근 가능한 폴더명"```을 주소 뒤에 추가  
        (ex.```localhost/../etc/passwd```)
 
    - **결과**:
        - Directory indexing  
        파일 구조
        ![Directory Indexing 0](/img/path/Directory%20Indexing%200.png)
        Not Found
        ![Directory Indexing 1](/img/path/Directory%20Indexing%201.png)
        ![Directory Indexing 2](/img/path/Directory%20Indexing%202.png)
        다만 밑 이미지에 해당하는 옵션 중 indexes를 설정해주면 indexing 가능
        ![Directory Indexing 3](/img/path/Directory%20Indexing%203.png)
        디렉토리 내부 파일엔 접근이 가능 - 취약점으로 보임
        ![Direct Access To File](/img/path/Direct%20Access%20To%20File.png)
        - Directory traversal  
        여러 가능한 경로를 설정해주었을 때 *index.php*가 출력됨.
        ![Directory Traversal 0](/img/path/Directory%20Traversal%200.png)
        ![Directory Traversal 1](/img/path/Directory%20Traversal%201.png)
    
    - **방어**:  
    Directory indexing의 경우 적절한 옵션 설정.  
    Directory traversal의 경우 path와 관련된 문자 처리, 프로세스의 디렉토리 이동을 제한하는 방법, Key-Value file system 사용하여 방어.

---

#### 3. Wrap Up

0. **Assets**  
서비스의 크기가 작아 에셋을 설정하는 데 어려움이 있었다.

1. **SQL injection**  
PHP 사이트 구축 시 의도치 않게 PDO를 사용하면서 SQL injection을 방어하게 되어 수행하지 적절한 공격을 수행하지 못했다. 기본적인 공격법인 만큼 이해를 위해 고의적으로 취약점을 만들어 수행해볼 것.

2. **Cross-site scripting**  
적절하게 수행되었다고는 생각하지만 asset에 접근하지 못한게 아쉬움. Payload에 관해 더 알아보고 critical한 취약점을 살펴볼 것.

3. **Session prediction & Session fixation**  
```session``` 생성, 파괴가 어떤 과정으로 이루어지는지 알아볼 것.

4. **Insufficient authorization**  
*POST* 과정에 ```session``` 확인이 없는 것까지 취약점을 파악, 이후 ```$id```를 변조하여 disguise 수행해볼 것.

5. **Sending plain data**  
패킷 변조 등을 통해 의도와 다른 수행 등 다양한 variation이 있을 듯. 정보를 전달하는 과정에 encryption, hashing 등의 작업을 추가하기.

6. **Directory indexing & Directory traversal**  
Directory indexing에서 옵션에 설정에 따라 취약점이 나뉘는 것을 확인.  
Directory traversal은 어떤 요건에 의해 이루어지는 지 조사 필요.


#### 4. WIP
- SQL injection을 수행하지 못해본 점이 아쉬움 -> 이후 source code 및 exploit 방법 교정 후 다시 시도

- 치명적인 공격이 가능한 XSS payload 찾기

- ```session_destroy()``` 이후 세션 id값이 바뀌지 않는 이유 확인

- Session hijacking 방식 찾기

- 인증(Authentification)과 인가(Authorization)의 차이 확인

- Hacking tool에 관해 정리(ex.*WireShark* VS *Burp Suite*)

- Directory 및 File 접근을 막기위한 방안 확인

- 시큐어코딩을 수행하고 결과 확인

---

#### 4. Review

- 피드백 후 추가 예정

---

#### 5. _Ref Links_

OWASP Top 10 

![OWASP TOP10 2017-2021](/img/OWASP/OWASP_TOP10_2017_2021.png)

1. A01:2021 - [Broken Access Control](https://owasp.org/Top10/A01_2021-Broken_Access_Control/)

2. A02:2021 - [Cryptographic Failures](https://owasp.org/Top10/A02_2021-Cryptographic_Failures/)

3. A03:2021 - [Injection](https://owasp.org/Top10/A03_2021-Injection/)

4. A04:2021 - [Insecure Design](https://owasp.org/Top10/A04_2021-Insecure_Design/)

5. A05:2021 - [Security Misconfiguration](https://owasp.org/Top10/A05_2021-Security_Misconfiguration/)

6. A06:2021 - [Vulnerable and Outdated Components](https://owasp.org/Top10/A06_2021-Vulnerable_and_Outdated_Components/)

7. A07:2021 - [Identification and Authentication Failures](https://owasp.org/Top10/A07_2021-Identification_and_Authentication_Failures/)

8. A08:2021 - [Software and Data Integrity Failures](https://owasp.org/Top10/A08_2021-Software_and_Data_Integrity_Failures/)

9. A09:2021 - [Security Logging and Monitoring Failures](https://owasp.org/Top10/A09_2021-Security_Logging_and_Monitoring_Failures/)

10. A10:2021 - [Server-Side Request Forgery](https://owasp.org/Top10/A10_2021-Server-Side_Request_Forgery_%28SSRF%29/)

---

[_Go to top_ ↑](#k-digital-training-information-security-3rd-assignment-3)