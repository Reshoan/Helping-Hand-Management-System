<?php

class UserModel
{
    private $pdo;
    private $oci;

    public function __construct($pdo, $oci)
    {
        $this->pdo = $pdo;
        $this->oci = $oci;
    }

    private function getNextUserId()
    {
        $query = "SELECT user_seq.NEXTVAL AS next_id FROM dual";
        $stid = oci_parse($this->oci, $query);
        oci_execute($stid);
        $row = oci_fetch_assoc($stid);
        return $row['NEXT_ID'];
    }

    public function register($data)
    {
        try {
            $this->pdo->beginTransaction();

            // Get next user ID
            $userId = $this->getNextUserId();

            // 1. Insert into Users
            $sqlUser = "INSERT INTO Users (us_id, us_name, us_password, us_address, us_phone_no, us_email, us_type)
                        VALUES (:us_id, :us_name, :us_password, :us_address, :us_phone_no, :us_email, :us_type)";
            $stmtUser = $this->pdo->prepare($sqlUser);
            $stmtUser->execute([
                ':us_id' => $userId,
                ':us_name' => $data['us_name'],
                ':us_password' => password_hash($data['us_password'], PASSWORD_DEFAULT),
                ':us_address' => $data['us_address'],
                ':us_phone_no' => $data['us_phone_no'],
                ':us_email' => $data['us_email'],
                ':us_type' => $data['us_type']
            ]);

            if ($data['us_type'] === 'service_provider') {
                // 2. Insert into Service_Provider
                $sqlSP = "INSERT INTO Service_Provider (sp_id, sp_experience, sp_gender, sp_dob, sp_nid_no, sp_expected_salary, sp_education, sp_certification, sp_type)
                          VALUES (:sp_id, :sp_experience, :sp_gender, TO_DATE(:sp_dob, 'YYYY-MM-DD'), :sp_nid_no, :sp_expected_salary, :sp_education, :sp_certification, :sp_type)";
                $stmtSP = $this->pdo->prepare($sqlSP);
                $stmtSP->execute([
                    ':sp_id' => $userId,
                    ':sp_experience' => $data['sp_experience'],
                    ':sp_gender' => $data['sp_gender'],
                    ':sp_dob' => $data['sp_dob'],
                    ':sp_nid_no' => $data['sp_nid_no'],
                    ':sp_expected_salary' => $data['sp_expected_salary'],
                    ':sp_education' => $data['sp_education'],
                    ':sp_certification' => $data['sp_certification'],
                    ':sp_type' => $data['sp_type']
                ]);

                // 3. Insert into specific service table
                $spType = strtolower(str_replace(' ', '', $data['sp_type']));
                switch ($spType) {
                    case 'cook':
                        $sql = "INSERT INTO Cook_Details (sp_id, ck_cuisine_expertise, ck_max_people_served)
                                VALUES (:sp_id, :ck_cuisine_expertise, :ck_max_people_served)";
                        $stmt = $this->pdo->prepare($sql);
                        $stmt->execute([
                            ':sp_id' => $userId,
                            ':ck_cuisine_expertise' => $data['ck_cuisine_expertise'],
                            ':ck_max_people_served' => $data['ck_max_people_served']
                        ]);
                        break;

                    case 'chauffer':
                        $sql = "INSERT INTO Chauffer_Details (sp_id, ch_vehicle_types, ch_licence_doc, ch_licence_valid_until)
                                VALUES (:sp_id, :ch_vehicle_types, :ch_licence_doc, TO_DATE(:ch_licence_valid_until, 'YYYY-MM-DD'))";
                        $stmt = $this->pdo->prepare($sql);
                        $stmt->execute([
                            ':sp_id' => $userId,
                            ':ch_vehicle_types' => $data['ch_vehicle_types'],
                            ':ch_licence_doc' => $data['ch_licence_doc'],
                            ':ch_licence_valid_until' => $data['ch_licence_valid_until']
                        ]);
                        break;

                    case 'cleaners':
                        $sql = "INSERT INTO Cleaner_Details (sp_id, cl_employment_type)
                                VALUES (:sp_id, :cl_employment_type)";
                        $stmt = $this->pdo->prepare($sql);
                        $stmt->execute([
                            ':sp_id' => $userId,
                            ':cl_employment_type' => $data['cl_employment_type']
                        ]);
                        break;

                    case 'securityguard':
                        $sql = "INSERT INTO SecurityGuard_Details (sp_id, sg_weapons_training)
                                VALUES (:sp_id, :sg_weapons_training)";
                        $stmt = $this->pdo->prepare($sql);
                        $stmt->execute([
                            ':sp_id' => $userId,
                            ':sg_weapons_training' => $data['sg_weapons_training']
                        ]);
                        break;

                    case 'relocators':
                        $sql = "INSERT INTO Relocator_Details (sp_id, rl_vehicle_type)
                                VALUES (:sp_id, :rl_vehicle_type)";
                        $stmt = $this->pdo->prepare($sql);
                        $stmt->execute([
                            ':sp_id' => $userId,
                            ':rl_vehicle_type' => $data['rl_vehicle_type']
                        ]);
                        break;

                    case 'babysitter':
                        $sql = "INSERT INTO Babysitter_Details (sp_id, bs_languages)
                                VALUES (:sp_id, :bs_languages)";
                        $stmt = $this->pdo->prepare($sql);
                        $stmt->execute([
                            ':sp_id' => $userId,
                            ':bs_languages' => $data['bs_languages']
                        ]);
                        break;

                    case 'masseuse':
                        $sql = "INSERT INTO Masseuse_Details (sp_id, ms_speciality)
                                VALUES (:sp_id, :ms_speciality)";
                        $stmt = $this->pdo->prepare($sql);
                        $stmt->execute([
                            ':sp_id' => $userId,
                            ':ms_speciality' => $data['ms_speciality']
                        ]);
                        break;

                    // plumber, electrician, gardener can be added similarly when schema is available
                }
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Registration failed: " . $e->getMessage());
            return false;
        }
    }
}
