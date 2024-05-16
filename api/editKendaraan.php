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
    $stmt_cek = $conn->prepare("SELECT id_murid FROM `murid_to_kendaraan` WHERE id_kendaraan = :id_kendaraan");
    $stmt_cek->execute([":id_kendaraan" => $id]);
    $tmp_count = $stmt_cek->rowCount();
    $array_tmp = $stmt_cek->fetchAll(PDO::FETCH_ASSOC);
    $array_tmp_flat = array_column($array_tmp, 'id_murid');


    if (strpos($murid, ',') !== false) {
        $array_murid = explode(",", $murid);
    } else {
        $array_murid = [];
        array_push($array_murid, $murid);
    }

    $murid_delete = array_values(array_diff($array_tmp_flat, $array_murid));

    // var_dump($murid_delete);

    // Menghasilkan array yang berisi elemen yang hanya ada di array kedua
    $murid_add = array_values(array_diff($array_murid, $array_tmp_flat));
    // var_dump($murid_add);

    // $data['pesan'] = "Id murid " . $row_murid . " tidak ditemukan!!";
    // die(json_encode($data));




    // if (count($murid_add) == 0) {
    //     $data['pesan'] = "Tidak ada murid yang ditambahkan";
    //     die(json_encode($data));
    // }
    if (count($murid_delete) == $tmp_count) {
        $stmt_cek = $conn->prepare("DELETE FROM `murid_to_kendaraan` WHERE id_kendaraan = :id_kendaraan");
        $stmt_cek->execute([":id_kendaraan" => $id]);
    } else {
        foreach ($murid_delete as $row_id) {
            $stmt_cek = $conn->prepare("DELETE FROM `murid_to_kendaraan` WHERE id_murid = :id_murid AND id_kendaraan = :id_kendaraan");
            $stmt_cek->execute([":id_murid" => $row_id, ":id_kendaraan" => $id]);
        }
    }


    // if (count($murid_delete) == 0) {
    //     echo (count($murid_add));
    //     $data['pesan'] = "Tidak ada murid yang ditambahkan";
    //     die(json_encode($data));
    // }

    // var_dump($murid_add);


    // print_r($uniqueToFirstArray);
    // print_r($uniqueToSecondArray);
    // $data['pesan'] = implode(',', $murid_add) . "delete" . implode(',', $murid_delete);


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
    // $stmt_cek = $conn->prepare("DELETE FROM `murid_to_kendaraan` WHERE id_kendaraan = :id_kendaraan");
    // $stmt_cek->execute([":id_kendaraan" => $id]);
    $stmt = $conn->prepare("UPDATE `db_kendaraan` SET `jenis_mobil`=:jenis,`plat_mobil`=:plat,`rfid_tag`=:rfid,`driver`=:driver WHERE id = :id");
    $stmt->execute([":jenis" => $jenis, ":plat" => $plat, ":rfid" => $rfid, ":driver" => $driver, ":id" => $id]);
    if (strpos($murid, ',') !== false) {
        // $array_murid = explode(",", $murid);
        if ($errorFile === 4) {
            foreach ($murid_add as $row_murid) {
                $stmt_cek = $conn->prepare("SELECT * FROM murid WHERE student_id = :student_id");
                $stmt_cek->execute([":student_id" => $row_murid]);
                if ($stmt_cek->rowCount() == 0) {
                    $data['pesan'] = "Id murid " . $row_murid . " tidak ditemukan!!";
                    die(json_encode($data));
                }
                $file = uniqid() . "" . ".wav";
                $kelas = $stmt_cek->fetch(PDO::FETCH_ASSOC);
                $text = "siswa " . $kelas['name'] . " kelas " . $kelas['grade'] . $kelas['class'] . " telah di jemput. harap bersiap di lobby utara.";
                $text = str_replace(" ", "+", $text);
                $current = file_get_contents("https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=" . $text . "&tl=id-ID");
                $filename = "../sound/" . $file;
                file_put_contents($filename, $current);
                $stmt2 = $conn->prepare("INSERT INTO `murid_to_kendaraan`(`id_murid`, `id_kendaraan`) VALUES (:id_murid,:id_kendaraan)");
                $stmt2->execute([":id_murid" => $row_murid, ":id_kendaraan" => $id]);
                $stmt3 = $conn->prepare("SELECT * FROM sound WHERE student_id = :id AND title = :title");
                $stmt3->execute([":id" => $row_murid, ":title" => "default"]);
                if ($stmt3->rowCount() == 0) {
                    $stmt = $conn->prepare("INSERT INTO `sound`(`student_id`, `sound`) VALUES (:student_id,:sound)");
                    $stmt->execute([":student_id" => $row_murid, ":sound" => $file]);
                }
                if ($row_murid == $murid_add[count($murid_add) - 1]) {
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
            $data['pesan'] = "Berhasil mengupdate Database";
            $data['success'] = true;
            die(json_encode($data));
        }
        if (in_array(strtolower(end($namaFile)), $allowed_foto)) {
            if ($sizeFile > 5_000_000) {
                $data['pesan'] = "Size image maximal 5MB!!";
                die(json_encode($data));
            }
            $namabukti = $plat . "_" . uniqid() . "." . strtolower(end($namaFile));
            $fileDestination = "../upload_foto/" . $namabukti;
            if (!(move_uploaded_file($penyimpananFile, $fileDestination))) {
                $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
                die(json_encode($data));
            }
            $stmt = $conn->prepare("UPDATE `db_kendaraan` SET `foto`=:foto WHERE id = :id");
            $stmt->execute([":foto" => $namabukti, ":id" => $id]);
            foreach ($murid_add as $row_murid) {
                $stmt_cek = $conn->prepare("SELECT * FROM murid WHERE student_id = :student_id");
                $stmt_cek->execute([":student_id" => $row_murid]);
                if ($stmt_cek->rowCount() == 0) {
                    $data['pesan'] = "Id murid " . $row_murid . " tidak ditemukan!!";
                    die(json_encode($data));
                }
                $file = uniqid() . "" . ".wav";
                $kelas = $stmt_cek->fetch(PDO::FETCH_ASSOC);
                $text = "siswa " . $kelas['name'] . " kelas " . $kelas['grade'] . $kelas['class'] . " telah di jemput. harap bersiap";
                $text = str_replace(" ", "+", $text);
                $current = file_get_contents("https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=" . $text . "&tl=id-ID");
                $filename = "../sound/" . $file;
                file_put_contents($filename, $current);
                $stmt2 = $conn->prepare("INSERT INTO `murid_to_kendaraan`(`id_murid`, `id_kendaraan`) VALUES (:id_murid,:id_kendaraan)");
                $stmt2->execute([":id_murid" => $row_murid, ":id_kendaraan" => $id]);
                $stmt3 = $conn->prepare("SELECT * FROM sound WHERE student_id = :id AND title = :title");
                $stmt3->execute([":id" => $row_murid, ":title" => "default"]);
                if ($stmt3->rowCount() == 0) {
                    $stmt = $conn->prepare("INSERT INTO `sound`(`student_id`, `sound`) VALUES (:student_id,:sound)");
                    $stmt->execute([":student_id" => $row_murid, ":sound" => $file]);
                }
                if ($row_murid == $murid_add[count($murid_add) - 1]) {
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
            $data['pesan'] = "Berhasil mengupdate Database";
            $data['success'] = true;
            die(json_encode($data));
        } else {
            $data['pesan'] = "Extension file harus berupa 'jpg', 'jpeg', 'png', 'heic' !!!";
            die(json_encode($data));
        }
    } else {
        if ($errorFile === 4) {
            if (count($murid_add) != 0) {
                $stmt_cek = $conn->prepare("SELECT * FROM murid WHERE student_id = :student_id");
                $stmt_cek->execute([":student_id" => $murid]);
                if ($stmt_cek->rowCount() == 0) {
                    $data['pesan'] = "Id murid tidak ditemukan!!";
                    die(json_encode($data));
                }
                $file = uniqid() . "" . ".wav";
                $kelas = $stmt_cek->fetch(PDO::FETCH_ASSOC);
                $text = "siswa " . $kelas['name'] . " kelas " . $kelas['grade'] . $kelas['class'] . " telah di jemput. harap bersiap di lobby utara.";
                $text = str_replace(" ", "+", $text);
                $current = file_get_contents("https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=" . $text . "&tl=id-ID");
                $filename = "../sound/" . $file;
                file_put_contents($filename, $current);
                $stmt2 = $conn->prepare("INSERT INTO `murid_to_kendaraan`(`id_murid`, `id_kendaraan`) VALUES (:id_murid,:id_kendaraan)");
                $stmt2->execute([":id_murid" => $murid, ":id_kendaraan" => $id]);
                $stmt3 = $conn->prepare("SELECT * FROM sound WHERE student_id = :id AND title = :title");
                $stmt3->execute([":id" => $murid, ":title" => "default"]);
                if ($stmt3->rowCount() == 0) {
                    $stmt = $conn->prepare("INSERT INTO `sound`(`student_id`, `sound`) VALUES (:student_id,:sound)");
                    $stmt->execute([":student_id" => $murid, ":sound" => $file]);
                }
                if ($stmt2->rowCount() > 0) {
                    $data['pesan'] = "Berhasil mengupdate Database";
                    $data['success'] = true;
                    die(json_encode($data));
                } else {
                    $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
                    die(json_encode($data));
                }
            }
            $data['pesan'] = "Berhasil mengupdate database";
            $data['success'] = true;
            die(json_encode($data));
        }
        if (in_array(strtolower(end($namaFile)), $allowed_foto)) {
            if ($sizeFile > 5_000_000) {
                $data['pesan'] = "Size image maximal 5MB!!";
                die(json_encode($data));
            }
            $namabukti = $plat . "_" . uniqid() . "." . strtolower(end($namaFile));
            $fileDestination = "../upload_foto/" . $namabukti;
            if (!(move_uploaded_file($penyimpananFile, $fileDestination))) {
                $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
                die(json_encode($data));
            }
            $stmt = $conn->prepare("UPDATE `db_kendaraan` SET `foto`=:foto WHERE id = :id");
            $stmt->execute([":foto" => $namabukti, ":id" => $id]);
            if (count($murid_add) != 0) {
                $stmt_cek = $conn->prepare("SELECT * FROM murid WHERE student_id = :student_id");
                $stmt_cek->execute([":student_id" => $murid]);
                if ($stmt_cek->rowCount() == 0) {
                    $data['pesan'] = "Id murid tidak ditemukan!!";
                    die(json_encode($data));
                }
                $file = uniqid() . "" . ".wav";
                $kelas = $stmt_cek->fetch(PDO::FETCH_ASSOC);
                $text = "siswa " . $kelas['name'] . " kelas " . $kelas['grade'] . $kelas['class'] . " telah di jemput. harap bersiap di lobby utara.";
                $text = str_replace(" ", "+", $text);
                $current = file_get_contents("https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=" . $text . "&tl=id-ID");
                $filename = "../sound/" . $file;
                file_put_contents($filename, $current);
                $stmt2 = $conn->prepare("INSERT INTO `murid_to_kendaraan`(`id_murid`, `id_kendaraan`) VALUES (:id_murid,:id_kendaraan)");
                $stmt2->execute([":id_murid" => $murid, ":id_kendaraan" => $id]);
                $stmt3 = $conn->prepare("SELECT * FROM sound WHERE student_id = :id AND title = :title");
                $stmt3->execute([":id" => $murid, ":title" => "default"]);
                if ($stmt3->rowCount() == 0) {
                    $stmt = $conn->prepare("INSERT INTO `sound`(`student_id`, `sound`) VALUES (:student_id,:sound)");
                    $stmt->execute([":student_id" => $murid, ":sound" => $file]);
                }
                if ($stmt2->rowCount() > 0) {
                    $data['pesan'] = "Berhasil mengupdate Database";
                    $data['success'] = true;
                    die(json_encode($data));
                } else {
                    $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
                    die(json_encode($data));
                }
            }
            $data['pesan'] = "Berhasil mengupdate database";
            $data['success'] = true;
            die(json_encode($data));
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
