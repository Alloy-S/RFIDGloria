<?php
include("../conn.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $data = ["success" => false, "pesan" => ""];
    $id = $_POST["id"];
    $jenis = $_POST['jenis'];
    $plat = $_POST['plat'];
    $rfid = $_POST['rfid'];
    $driver = $_POST['driver'];
    $murid = $_POST['murid'];
    $namaFile = $_FILES["foto_mobil"]['name'];
    $errorFile = $_FILES["foto_mobil"]['error'];
    $sizeFile = $_FILES["foto_mobil"]['size'];
    $penyimpananFile = $_FILES["foto_mobil"]['tmp_name'];
    $namaFile = explode(".", $namaFile);
    $allowed_foto = array('jpg', 'jpeg', 'png', 'heic');
    // $stmt_cek = $conn->prepare("SELECT * FROM db_kendaraan WHERE rfid_tag = :rfid AND id <> :id");
    // $stmt_cek->execute([":rfid" => $rfid, ":id" => $id]);
    // if ($stmt_cek->rowCount() >= 1) {
    //     $data['pesan'] = "RFID sudah terdaftar!!";
    //     die(json_encode($data));
    // }
    // $stmt_cek = $conn->prepare("SELECT * FROM db_kendaraan WHERE plat_mobil = :plat AND id <> :id");
    // $stmt_cek->execute([":plat" => $plat, ":id" => $id]);
    // if ($stmt_cek->rowCount() >= 1) {
    //     $data['pesan'] = "Plat mobil sudah terdaftar!!";
    //     die(json_encode($data));
    // }
    // $stmt_cek = $conn->prepare("SELECT * FROM murid WHERE student_id = :murid");
    // $stmt_cek->execute([":murid" => $murid]);
    // if ($stmt_cek->rowCount() < 1) {
    //     $data['pesan'] = "Id murid tidak terdaftar!!";
    //     die(json_encode($data));
    // }
    $stmt_cek = $conn->prepare("DELETE FROM `murid_to_kendaraan` WHERE id_kendaraan = :id_kendaraan");
    $stmt_cek->execute([":id_kendaraan" => $id]);
    $stmt = $conn->prepare("UPDATE `db_kendaraan` SET `jenis_mobil`=:jenis,`plat_mobil`=:plat,`rfid_tag`=:rfid,`driver`=:driver WHERE id = :id");
    $stmt->execute([":jenis" => $jenis, ":plat" => $plat, ":rfid" => $rfid, ":driver" => $driver, ":id" => $id]);
    if (strpos($murid, ',') !== false) {
        $array_murid = explode(",", $murid);
        if ($errorFile === 4) {
            foreach ($array_murid as $row_murid) {
                $stmt_cek = $conn->prepare("SELECT * FROM murid WHERE student_id = :student_id");
                $stmt_cek->execute([":student_id" => $row_murid]);
                if ($stmt_cek->rowCount() == 0) {
                    $data['pesan'] = "Id murid " . $row_murid . " tidak ditemukan!!";
                    die(json_encode($data));
                }
                $file = uniqid('', true) . "" . ".wav";
                $kelas = $stmt_cek->fetch(PDO::FETCH_ASSOC);
                $text = "siswa " . $row_murid . " kelas " . $kelas['grade'] . $kelas['class'] . " telah di jemput. harap bersiap di lobby utara.";
                $text = str_replace(" ", "+", $text);
                $current = file_get_contents("https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=" . $text . "&tl=id-ID");
                file_put_contents($file, $current);
                $stmt2 = $conn->prepare("INSERT INTO `murid_to_kendaraan`(`id_murid`, `id_kendaraan`, `sound`) VALUES (:id_murid,:id_kendaraan,:sound)");
                $stmt2->execute([":id_murid" => $row_murid, ":id_kendaraan" => $id, ":sound" => $file]);
                if ($row_murid == $array_murid[count($array_murid) - 1]) {
                    if ($stmt2->rowCount() > 0) {
                        $data['pesan'] = "Berhasil mengupdate Database";
                        $data['success'] = true;
                        die(json_encode($data));
                    } else {
                        $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat 2";
                        die(json_encode($data));
                    }
                } else {
                    if ($stmt2->rowCount() == 0) {
                        $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
                        die(json_encode($data));
                    }
                }
            }
        }
        if (in_array(strtolower(end($namaFile)), $allowed_foto)) {
            if ($sizeFile > 5_000_000) {
                $data['pesan'] = "Size image maximal 5MB!!";
                die(json_encode($data));
            }
            $namabukti = $rfid . "_" . uniqid('', true) . "." . strtolower(end($namaFile));
            $fileDestination = "../upload_foto/" . $namabukti;
            if (!(move_uploaded_file($penyimpananFile, $fileDestination))) {
                $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
                die(json_encode($data));
            }
            foreach ($array_murid as $row_murid) {
                $stmt_cek = $conn->prepare("SELECT * FROM murid WHERE student_id = :student_id");
                $stmt_cek->execute([":student_id" => $row_murid]);
                if ($stmt_cek->rowCount() == 0) {
                    $data['pesan'] = "Id murid " . $row_murid . " tidak ditemukan!!";
                    die(json_encode($data));
                }
                $file = uniqid('', true) . "" . ".wav";
                $kelas = $stmt_cek->fetch(PDO::FETCH_ASSOC);
                $text = "siswa " . $murid . " kelas " . $kelas['grade'] . $kelas['class'] . " telah di jemput. harap bersiap di lobby utara.";
                $text = str_replace(" ", "+", $text);
                $current = file_get_contents("https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=" . $text . "&tl=id-ID");
                file_put_contents($file, $current);
                $stmt2 = $conn->prepare("INSERT INTO `murid_to_kendaraan`(`id_murid`, `id_kendaraan`, `sound`) VALUES (:id_murid,:id_kendaraan,:sound)");
                $stmt2->execute([":id_murid" => $row_murid, ":id_kendaraan" => $id, ":sound" => $file]);
                if ($row_murid == $array_murid[count($array_murid) - 1]) {
                    if ($stmt2->rowCount() > 0) {
                        $data['pesan'] = "Berhasil mengupdate Database";
                        $data['success'] = true;
                        die(json_encode($data));
                    } else {
                        $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
                        die(json_encode($data));
                    }
                } else {
                    if ($stmt2->rowCount() == 0) {
                        $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
                        die(json_encode($data));
                    }
                }
            }
        } else {
            $data['pesan'] = "Extension file harus berupa 'jpg', 'jpeg', 'png', 'heic' !!!";
            die(json_encode($data));
        }
    } else {
        if ($errorFile === 4) {
            $stmt_cek = $conn->prepare("SELECT * FROM murid WHERE student_id = :student_id");
            $stmt_cek->execute([":student_id" => $murid]);
            if ($stmt_cek->rowCount() == 0) {
                $data['pesan'] = "Id murid tidak ditemukan!!";
                die(json_encode($data));
            }
            $file = uniqid('', true) . "" . ".wav";
            $kelas = $stmt_cek->fetch(PDO::FETCH_ASSOC);
            $text = "siswa " . $murid . " kelas " . $kelas['grade'] . $kelas['class'] . " telah di jemput. harap bersiap di lobby utara.";
            $text = str_replace(" ", "+", $text);
            $current = file_get_contents("https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=" . $text . "&tl=id-ID");
            file_put_contents($file, $current);
            $stmt_cek = $conn->prepare("DELETE FROM `murid_to_kendaraan` WHERE id_kendaraan = :id_kendaraan");
            $stmt_cek->execute([":id_kendaraan" => $id]);
            $stmt2 = $conn->prepare("INSERT INTO `murid_to_kendaraan`(`id_murid`, `id_kendaraan`, `sound`) VALUES (:id_murid,:id_kendaraan,:sound)");
            $stmt2->execute([":id_murid" => $murid, ":id_kendaraan" => $id, ":sound" => $file]);
            if ($stmt2->rowCount() > 0) {
                $data['pesan'] = "Berhasil mengupdate Database";
                $data['success'] = true;
                die(json_encode($data));
            } else {
                $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
                die(json_encode($data));
            }
        }
        if (in_array(strtolower(end($namaFile)), $allowed_foto)) {
            if ($sizeFile > 5_000_000) {
                $data['pesan'] = "Size image maximal 5MB!!";
                die(json_encode($data));
            }
            $namabukti = $rfid . "_" . uniqid('', true) . "." . strtolower(end($namaFile));
            $fileDestination = "../upload_foto/" . $namabukti;
            if (!(move_uploaded_file($penyimpananFile, $fileDestination))) {
                $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
                die(json_encode($data));
            }
            $stmt_cek = $conn->prepare("SELECT * FROM murid WHERE student_id = :student_id");
            $stmt_cek->execute([":student_id" => $murid]);
            if ($stmt_cek->rowCount() == 0) {
                $data['pesan'] = "Id murid tidak ditemukan!!";
                die(json_encode($data));
            }
            $file = uniqid('', true) . "" . ".wav";
            $kelas = $stmt_cek->fetch(PDO::FETCH_ASSOC);
            $text = "siswa " . $murid . " kelas " . $kelas['grade'] . $kelas['class'] . " telah di jemput. harap bersiap di lobby utara.";
            $text = str_replace(" ", "+", $text);
            $current = file_get_contents("https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=" . $text . "&tl=id-ID");
            file_put_contents($file, $current);
            $stmt_cek = $conn->prepare("DELETE FROM `murid_to_kendaraan` WHERE id_kendaraan = :id_kendaraan");
            $stmt_cek->execute([":id_kendaraan" => $id]);
            $stmt2 = $conn->prepare("INSERT INTO `murid_to_kendaraan`(`id_murid`, `id_kendaraan`, `sound`) VALUES (:id_murid,:id_kendaraan,:sound)");
            $stmt2->execute([":id_murid" => $murid, ":id_kendaraan" => $id, ":sound" => $file]);
            if ($stmt2->rowCount() > 0) {
                $data['pesan'] = "Berhasil mengupdate Database";
                $data['success'] = true;
                die(json_encode($data));
            } else {
                $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
                die(json_encode($data));
            }
        } else {
            $data['pesan'] = "Extension file harus berupa 'jpg', 'jpeg', 'png', 'heic' !!!";
            die(json_encode($data));
        }
    }
    // if ($errorFile === 4) {
    //     $file = uniqid('', true) . "" . ".wav";
    //     $kelas = $stmt_cek->fetch(PDO::FETCH_ASSOC);
    //     $text = "siswa " . $row_murid . " kelas " . $kelas['grade'] . $kelas['class'] . " telah di jemput. harap bersiap di lobby utara.";
    //     $text = str_replace(" ", "+", $text);
    //     $current = file_get_contents("https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=" . $text . "&tl=id-ID");
    //     file_put_contents($file, $current);
    //     $stmt2 = $conn->prepare("UPDATE `murid_to_kendaraan` SET `id_murid`=:id_murid WHERE id_kendaraan=:id_kendaraan");
    //     $stmt2->execute([":id_murid" => $murid, ":id_kendaraan" => $id]);
    //     $stmt = $conn->prepare("UPDATE `db_kendaraan` SET `jenis_mobil`=:jenis,`plat_mobil`=:plat,`rfid_tag`=:rfid,`driver`=:driver WHERE id = :id");
    //     $stmt->execute([":jenis" => $jenis, ":plat" => $plat, ":rfid" => $rfid, ":driver" => $driver, ":id" => $id]);
    //     if ($stmt->rowCount() > 0 or $stmt2->rowCount() > 0) {
    //         $data['pesan'] = "Berhasil mengupdate Database";
    //         $data['success'] = true;
    //         die(json_encode($data));
    //     } else {
    //         $data['pesan'] = "Tidak ada data yang diupdate!";
    //         die(json_encode($data));
    //     }
    // }
    // if (in_array(strtolower(end($namaFile)), $allowed_foto)) {
    //     if ($sizeFile > 5_000_000) {
    //         $data['pesan'] = "Size image maximal 5MB!!";
    //         die(json_encode($data));
    //     }
    //     $namabukti = $rfid . "_" . uniqid('', true) . "." . strtolower(end($namaFile));
    //     $fileDestination = "../upload_foto/" . $namabukti;
    //     if (!(move_uploaded_file($penyimpananFile, $fileDestination))) {
    //         $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
    //         die(json_encode($data));
    //     }
    //     $stmt2 = $conn->prepare("UPDATE `murid_to_kendaraan` SET `id_murid`=:id_murid WHERE id_kendaraan=:id_kendaraan");
    //     $stmt2->execute([":id_murid" => $murid, ":id_kendaraan" => $id]);
    //     $stmt = $conn->prepare("UPDATE `db_kendaraan` SET `jenis_mobil`=:jenis,`plat_mobil`=:plat,`rfid_tag`=:rfid,`driver`=:driver,`id_murid`=:murid,`foto`=:foto WHERE id = :id");
    //     $stmt->execute([":jenis" => $jenis, ":plat" => $plat, ":rfid" => $rfid, ":driver" => $driver, ":murid" => $murid, ":foto" => $namabukti, ":id" => $id]);
    //     if ($stmt->rowCount() > 0) {
    //         $data['pesan'] = "Berhasil mengupdate Database";
    //         $data['success'] = true;
    //         die(json_encode($data));
    //     } else {
    //         $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
    //         die(json_encode($data));
    //     }
    // } else {
    //     $data['pesan'] = "Extension file harus berupa 'jpg', 'jpeg', 'png', 'heic' !!!";
    //     die(json_encode($data));
    // }
}
