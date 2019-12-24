<?php

namespace iot\connection;

use MongoDB\BSON\Persistable;

class connection{
    private $connect;

    /**
     * @return connection
     */
    public static function initDatabase(){
        define("DBHOSTNAME", "127.0.0.1");
        define("DBUSERNAME", "root");
        define("DBPASSWORD", "");
        define("DBNAME", "db_iot");
        $connect = mysqli_connect(DBHOSTNAME, DBUSERNAME, DBPASSWORD, DBNAME) or die(mysqli_error($connect));

        if($connect->connect_error){
            die("Connection to Database Failed");
        }else{
            $statement = new self();
            $statement->connect = $connect;
            return $statement;
        }
    }

    public function login($username, $password){
        $username = mysqli_real_escape_string($this->connect, $username);
        $password = mysqli_real_escape_string($this->connect, $password);

        if(empty($username) || empty($password)){
            return false;
        }

        $password = md5($password);

        $login = $this->connect->prepare('SELECT usr_id, usr_username, usr_email, usr_foto, usr_role FROM tbl_user WHERE usr_username = ? AND usr_password = ?');
        $login->bind_param('ss', $username, $password);
        $login->execute();
        $login->store_result();
        if($login->num_rows == 0){
            $_SESSION['message'] = 'Username/password tidak ditemukan';
            return false;
        }

        $loginDetail['log_detail'] = array();
        $login->bind_result($usrId, $usrUsername, $usrEmail, $usrFoto, $usrRole);
        while($login->fetch()){
            array_push($loginDetail['log_detail'], [
                'id' => $usrId,
                'username' =>$usrUsername,
                'email' => $usrEmail,
                'foto' => $usrFoto,
                'role' => $usrRole
            ]);
        }
        return $loginDetail['log_detail'];
    }

    public function addUser($username, $password, $email, $role = 1){
        $username = mysqli_real_escape_string($this->connect, $username);
        $password = mysqli_real_escape_string($this->connect, $password);
        $email    = mysqli_real_escape_string($this->connect, $email);
        $role     = mysqli_real_escape_string($this->connect, $role);
        $role = 1;
        $add = $this->connect->prepare('INSERT INTO tbl_user(usr_username, usr_password, usr_email, usr_role, usr_created_at) 
              VALUES(?,?,?,?,NOW())');
        $add->bind_param('sssi', $username, $password, $email, $role);
        $add->execute();
        $add->store_result();

        if($add->num_rows == 0){
            $_SESSION['message'] = 'Registrasi gagal';
            return false;
        }
        return true;
    }

    public function addDataLog($usr_id, $kodeAlat, $soc, $iac, $vac, $power_ac, $energi_ac, $ipv, $vpv, $tanggal){
        $usr_id     = mysqli_real_escape_string($this->connect, $usr_id);
        $kodeAlat   = mysqli_real_escape_string($this->connect, $kodeAlat);
        $soc        = mysqli_real_escape_string($this->connect, $soc);
        $iac        = mysqli_real_escape_string($this->connect, $iac);
        $vac        = mysqli_real_escape_string($this->connect, $vac);
        $power_ac   = mysqli_real_escape_string($this->connect, $power_ac);
        $energi_ac  = mysqli_real_escape_string($this->connect, $energi_ac);
        $ipv        = mysqli_real_escape_string($this->connect, $ipv);
        $vpv        = mysqli_real_escape_string($this->connect, $vpv);
        $tanggal    = mysqli_real_escape_string($this->connect, $tanggal);

        $add = $this->connect->prepare('INSERT INTO tbl_datalog(usr_id, dat_kode, dat_soc, dat_iac, dat_vac, dat_powerac, dat_energiac, dat_ipv, dat_vpv, dat_tanggal) 
            VALUES(?,?,?,?,?,?,?,?,?,?)');
        $add->bind_param('isssssssss', $usr_id, $kodeAlat, $soc, $iac, $vac, $power_ac, $energi_ac, $ipv, $vpv, $tanggal);
        $add->execute();
        $add->store_result();

        if($add->affected_rows == 0){
            $_SESSION['message'] = 'Data gagal diupload';
            return false;
        }
        return true;
    }

    public function getDataLog($role, $usr_id = null){
        $usr_id     = mysqli_real_escape_string($this->connect, $usr_id);

        if($usr_id === null){
            $_SESSION['message'] = "User ID tidak ditemukan";
            return false;
        }

        if($role){
            $get = $this->connect->prepare('SELECT dat_id, usr_id, dat_kode, dat_soc, dat_iac, dat_vac, dat_powerac, dat_energiac, dat_ipv, dat_vpv, dat_tanggal 
                FROM tbl_datalog');
        }else{
            $get = $this->connect->prepare('SELECT dat_id, usr_id, dat_kode, dat_soc, dat_iac, dat_vac, dat_powerac, dat_energiac, dat_ipv, dat_vpv, dat_tanggal
                FROM tbl_datalog where usr_id = ?');
            $get->bind_param('i', $usr_id);
        }

        $get->execute();
        $get->store_result();

        if($get->num_rows == 0){
            $_SESSION['message'] = "Data log tidak tersedia";
            return false;
        }
        $logDetails['log_detail'] = array();
        $get->bind_result($dat_id, $usr_id, $kodeAlat, $soc, $iac, $vac, $power_ac, $energi_ac, $ipv, $vpv, $tanggal);
        while($get->fetch()){
            array_push($logDetails['log_detail'], [
                'dat_id'    => $dat_id,
                'usr_id'    => $usr_id,
                'kodeAlat'  => $kodeAlat,
                'soc'       => $soc,
                'iac'       => $iac,
                'vac'       => $vac,
                'power_ac'  => $power_ac,
                'energi_ac' => $energi_ac,
                'ipv'       => $ipv,
                'vpv'       => $vpv,
                'tanggal'   => $tanggal
            ]);
        }
        return $logDetails['log_detail'];
    }

    public function getDataLogByID($dat_id = null){
        $dat_id     = mysqli_real_escape_string($this->connect, $dat_id);

        if($dat_id === null){
            $_SESSION['message'] = "Data Log ID tidak ditemukan";
            return false;
        }

        $get = $this->connect->prepare('SELECT dat_id, usr_id, dat_kode, dat_soc, dat_iac, dat_vac, dat_powerac, dat_energiac, dat_ipv, dat_vpv, dat_tanggal 
            FROM tbl_datalog WHERE dat_id = ?');
        $get->bind_param('i', $dat_id);
        $get->execute();
        $get->store_result();

        if($get->num_rows == 0){
            $_SESSION['message'] = "Data log tidak tersedia";
            return false;
        }

        $logDetails['log_detail'] = array();
        $get->bind_result($dat_id, $usr_id, $kodeAlat, $soc, $iac, $vac, $power_ac, $energi_ac, $ipv, $vpv, $tanggal);
        while($get->fetch()){
            array_push($logDetails['log_detail'], [
                'dat_id'    => $dat_id,
                'usr_id'    => $usr_id,
                'kodeAlat'  => $kodeAlat,
                'soc'       => $soc,
                'iac'       => $iac,
                'vac'       => $vac,
                'power_ac'  => $power_ac,
                'energi_ac' => $energi_ac,
                'ipv'       => $ipv,
                'vpv'       => $vpv,
                'tanggal'   => $tanggal
            ]);
        }
        return $logDetails['log_detail'];
    }

    public function editDataLog($dat_id, $kodeAlat, $soc, $iac, $vac, $power_ac, $energi_ac, $ipv, $vpv, $tanggal){
        $dat_id     = mysqli_real_escape_string($this->connect, $dat_id);
        $kodeAlat   = mysqli_real_escape_string($this->connect, $kodeAlat);
        $soc        = mysqli_real_escape_string($this->connect, $soc);
        $iac        = mysqli_real_escape_string($this->connect, $iac);
        $vac        = mysqli_real_escape_string($this->connect, $vac);
        $power_ac   = mysqli_real_escape_string($this->connect, $power_ac);
        $energi_ac  = mysqli_real_escape_string($this->connect, $energi_ac);
        $ipv        = mysqli_real_escape_string($this->connect, $ipv);
        $vpv        = mysqli_real_escape_string($this->connect, $vpv);
        $tanggal    = mysqli_real_escape_string($this->connect, $tanggal);

        $add = $this->connect->prepare('UPDATE tbl_datalog SET dat_kode = ?, dat_soc = ?, dat_iac = ?, dat_vac = ?, 
            dat_powerac = ?, dat_energiac = ?, dat_ipv = ?, dat_vpv = ?, dat_tanggal = ? WHERE dat_id = ?');
        $add->bind_param('sssssssssi', $kodeAlat, $soc, $iac, $vac, $power_ac, $energi_ac, $ipv, $vpv, $tanggal, $dat_id);
        $add->execute();
        $add->store_result();

        if($add->affected_rows == 0){
            $_SESSION['message'] = 'Data gagal diubah';
            return false;
        }
        return true;
    }

    public function deleteDatalogByID($dat_id){
        $dat_id     = mysqli_real_escape_string($this->connect, $dat_id);

        $del = $this->connect->prepare('DELETE FROM tbl_datalog WHERE dat_id = ?');
        $del->bind_param('i', $dat_id);
        $del->execute();
        $del->store_result();

        if($del->affected_rows == 0){
            $_SESSION['message'] = "Gagal delete data";
            return false;
        }

        return true;
    }

    public function addPeminjaman($usr_id, $nama, $alamat, $foto_pmj, $foto_kk, $foto_ktp, $jenis_alat){
        $usr_id     = mysqli_real_escape_string($this->connect, $usr_id);
        $nama       = mysqli_real_escape_string($this->connect, $nama);
        $alamat     = mysqli_real_escape_string($this->connect, $alamat);
        $foto_pmj   = mysqli_real_escape_string($this->connect, $foto_pmj);
        $foto_kk    = mysqli_real_escape_string($this->connect, $foto_kk);
        $foto_ktp   = mysqli_real_escape_string($this->connect, $foto_ktp);
        $jenis_alat = mysqli_real_escape_string($this->connect, $jenis_alat);

        $add = $this->connect->prepare('INSERT INTO tbl_peminjaman(usr_id, pmj_nama, pmj_alamat, pmj_foto, pmj_kk, pmj_ktp, pmj_jenisalat) VALUES(?,?,?,?,?,?,?)');
        $add->bind_param('issssss', $usr_id, $nama, $alamat, $foto_pmj, $foto_kk, $foto_ktp, $jenis_alat);
        $add->execute();
        $add->store_result();

        if($add->affected_rows == 0){
            $_SESSION['message'] = 'Gagal memasukan data peminjaman';
            return false;
        }
        return true;
    }

    public function getAllPeminjamanByID($role, $usr_id = null){
        $usr_id     = mysqli_real_escape_string($this->connect, $usr_id);

        if($usr_id === null){
            $_SESSION['message'] = "User ID tidak ditemukan";
            return false;
        }

        if($role){
            $get = $this->connect->prepare('SELECT pmj_id, pmj_nama, pmj_alamat, pmj_foto, pmj_kk, pmj_ktp, pmj_jenisalat FROM tbl_peminjaman');
        }else{
            $get = $this->connect->prepare('SELECT pmj_id, pmj_nama, pmj_alamat, pmj_foto, pmj_kk, pmj_ktp, pmj_jenisalat FROM tbl_peminjaman WHERE usr_id = ?');
            $get->bind_param('i', $usr_id);
        }

        $get->execute();
        $get->store_result();

        if($get->num_rows == 0){
            $_SESSION['message'] = "Peminjaman tidak tersedia";
            return false;
        }

        $pmjDetails['pmj_detail'] = array();
        $get->bind_result($pmj_id, $pmj_nama, $pmj_alamat, $pmj_foto, $pmj_kk, $pmj_ktp, $pmj_jenisalat);
        while($get->fetch()){
            array_push($pmjDetails['pmj_detail'], [
                'id'        => $pmj_id,
                'nama'      => $pmj_nama,
                'alamat'    => $pmj_alamat,
                'foto'      => $pmj_foto,
                'kk'        => $pmj_kk,
                'ktp'       => $pmj_ktp,
                'jenisalat' => $pmj_jenisalat
            ]);
        }
        return $pmjDetails['pmj_detail'];
    }

    public function getPeminjamanByID($pmj_id = null){
        $pmj_id     = mysqli_real_escape_string($this->connect, $pmj_id);

        if($pmj_id === null){
            $_SESSION['message'] = "User ID tidak ditemukan";
            return false;
        }

        $get = $this->connect->prepare('SELECT pmj_id, pmj_nama, pmj_alamat, pmj_foto, pmj_kk, pmj_ktp, pmj_jenisalat FROM tbl_peminjaman WHERE pmj_id = ?');
        $get->bind_param('i', $pmj_id);
        $get->execute();
        $get->store_result();

        if($get->num_rows == 0){
            $_SESSION['message'] = "Peminjaman tidak tersedia";
            return false;
        }

        $pmjDetails['pmj_detail'] = array();
        $get->bind_result($pmj_id, $pmj_nama, $pmj_alamat, $pmj_foto, $pmj_kk, $pmj_ktp, $pmj_jenisalat);
        while($get->fetch()){
            array_push($pmjDetails['pmj_detail'], [
                'id'        => $pmj_id,
                'nama'      => $pmj_nama,
                'alamat'    => $pmj_alamat,
                'foto'      => $pmj_foto,
                'kk'        => $pmj_kk,
                'ktp'       => $pmj_ktp,
                'jenisalat' => $pmj_jenisalat
            ]);
        }
        return $pmjDetails['pmj_detail'];
    }

    public function editPeminjaman($pmj_id, $nama, $alamat, $foto_pmj, $foto_kk, $foto_ktp, $jenis_alat){
        $pmj_id     = mysqli_real_escape_string($this->connect, $pmj_id);
        $nama       = mysqli_real_escape_string($this->connect, $nama);
        $alamat     = mysqli_real_escape_string($this->connect, $alamat);
        $foto_pmj   = mysqli_real_escape_string($this->connect, $foto_pmj);
        $foto_kk    = mysqli_real_escape_string($this->connect, $foto_kk);
        $foto_ktp   = mysqli_real_escape_string($this->connect, $foto_ktp);
        $jenis_alat = mysqli_real_escape_string($this->connect, $jenis_alat);

        $add = $this->connect->prepare('UPDATE tbl_peminjaman SET pmj_nama = ?, pmj_alamat = ?, pmj_foto = ?, pmj_kk = ?, pmj_ktp = ?, pmj_jenisalat = ? WHERE pmj_id = ?');
        $add->bind_param('ssssssi', $nama, $alamat,$foto_pmj, $foto_kk, $foto_ktp, $jenis_alat, $pmj_id);
        $add->execute();
        $add->store_result();

        if($add->affected_rows == 0){
            $_SESSION['message'] = 'Gagal merubah data peminjaman';
            return false;
        }
        return true;
    }

    public function deletePeminjaman($pmj_id){
        $pmj_id     = mysqli_real_escape_string($this->connect, $pmj_id);

        $del = $this->connect->prepare('DELETE FROM tbl_peminjaman WHERE pmj_id = ?');
        $del->bind_param('i', $pmj_id);
        $del->execute();
        $del->store_result();

        if($del->affected_rows == 0){
            $_SESSION['message'] = "Gagal delete data";
            return false;
        }

        return true;
    }

    public function getAccount($role, $usr_id = null){
        $usr_id = mysqli_real_escape_string($this->connect, $usr_id);
        if($role){
            $get = $this->connect->prepare('SELECT usr_id, usr_username, usr_email, usr_alamat, usr_foto, usr_ktp FROM tbl_user');
        }else{
            $get = $this->connect->prepare('SELECT usr_id, usr_username, usr_email, usr_alamat, usr_foto, usr_ktp FROM tbl_user WHERE usr_id = ?');
            $get->bind_param('i', $usr_id);
        }

        $get->execute();
        $get->store_result();

        if($get->num_rows == 0){
            $_SESSION['message'] = 'Akun tidak tersedia';
            return false;
        }

        $accDetails['acc_detail'] = array();
        $get->bind_result($id, $username, $email, $alamat, $foto, $ktp);
        while($get->fetch()){
            array_push($accDetails['acc_detail'], [
                'id'        => $id,
                'username'  => $username,
                'email'     => $email,
                'alamat'    => $alamat,
                'foto'      => $foto,
                'ktp'       => $ktp
            ]);
        }
        return $accDetails['acc_detail'];
    }

    public function getAccountByID($usr_id = null){
        $usr_id = mysqli_real_escape_string($this->connect, $usr_id);
        $get = $this->connect->prepare('SELECT usr_id, usr_username, usr_email, usr_alamat, usr_foto, usr_ktp FROM tbl_user WHERE usr_id = ?');
        $get->bind_param('i', $usr_id);
        $get->execute();
        $get->store_result();

        if($get->num_rows == 0){
            $_SESSION['message'] = 'Akun tidak tersedia';
            return false;
        }

        $accDetails['acc_detail'] = array();
        $get->bind_result($id, $username, $email, $alamat, $foto, $ktp);
        while($get->fetch()){
            array_push($accDetails['acc_detail'], [
                'id'        => $id,
                'username'  => $username,
                'email'     => $email,
                'alamat'    => $alamat,
                'foto'      => $foto,
                'ktp'       => $ktp
            ]);
        }
        return $accDetails['acc_detail'];
    }

    public function checkAccountByUsername($username){
        $username = mysqli_real_escape_string($this->connect, $username);

        $get = $this->connect->prepare('SELECT * FROM tbl_user WHERE usr_username = ?');
        $get->bind_param('s', $username);
        $get->execute();
        $get->store_result();

        if($get->num_rows == 0){
            return false;
        }

        return true;
    }

    public function checkAccountByEmail($email){
        $email = mysqli_real_escape_string($this->connect, $email);

        $get = $this->connect->prepare('SELECT * FROM tbl_user WHERE usr_email = ?');
        $get->bind_param('s', $email);
        $get->execute();
        $get->store_result();

        if($get->num_rows == 0){
            return false;
        }

        return true;
    }

    public function addAccount($username, $email, $password, $alamat, $fotoAcc, $fotoKtp, $role = 0){
        unset($_SESSION['message']);
        $username = mysqli_real_escape_string($this->connect, $username);
        $email    = mysqli_real_escape_string($this->connect, $email);
        $password = mysqli_real_escape_string($this->connect, $password);
        $alamat   = mysqli_real_escape_string($this->connect, $alamat);
        $fotoAcc  = mysqli_real_escape_string($this->connect, $fotoAcc);
        $fotoKtp  = mysqli_real_escape_string($this->connect, $fotoKtp);
        $role     = mysqli_real_escape_string($this->connect, $role);

        if($this->checkAccountByUsername($username)){
            $_SESSION['message'] = 'Username telah terdaftar';
            return false;
        }

        if($this->checkAccountByEmail($email)){
            $_SESSION['message'] = 'Email telah terdaftar';
            return false;
        }

        $password = md5($password);

        $add = $this->connect->prepare('INSERT INTO tbl_user (usr_username, usr_password, usr_email, usr_alamat, usr_ktp, usr_foto, usr_role)
            VALUES(?,?,?,?,?,?,?)');
        $add->bind_param('sssssss', $username, $password, $email, $alamat, $fotoKtp, $fotoAcc, $role);
        $add->execute();
        $add->store_result();

        if($add->affected_rows == 0){
            $_SESSION['message'] = 'Gagal menambahkan akun';
            return false;
        }

        return true;
    }

    public function editAccount($id, $username, $email, $alamat, $fotoAcc, $fotoKtp){
        $id       = mysqli_real_escape_string($this->connect, $id);
        $username = mysqli_real_escape_string($this->connect, $username);
        $email    = mysqli_real_escape_string($this->connect, $email);
        $alamat   = mysqli_real_escape_string($this->connect, $alamat);
        $fotoAcc  = mysqli_real_escape_string($this->connect, $fotoAcc);
        $fotoKtp  = mysqli_real_escape_string($this->connect, $fotoKtp);

        $edit = $this->connect->prepare('UPDATE tbl_user SET usr_username = ?, usr_email = ?, usr_alamat = ?, usr_foto = ?, usr_ktp = ? WHERE usr_id = ?');
        $edit->bind_param('sssssi', $username, $email, $alamat, $fotoAcc, $fotoKtp, $id);
        $edit->execute();
        $edit->store_result();

        if($edit->affected_rows == 0){
            $_SESSION['message'] = 'Gagal merubah akun';
            return false;
        }
        return true;
    }

    public function deleteAccount($usr_id){
        $usr_id     = mysqli_real_escape_string($this->connect, $usr_id);

        $del = $this->connect->prepare('DELETE FROM tbl_user WHERE usr_id = ?');
        $del->bind_param('i', $usr_id);
        $del->execute();
        $del->store_result();

        if($del->affected_rows == 0){
            $_SESSION['message'] = "Gagal delete data";
            return false;
        }

        return true;
    }
}