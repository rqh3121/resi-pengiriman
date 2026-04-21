<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $branches = [
            ["city" => "PT PELNI CAB SEMARANG", "address" => "JL. EMPU TANTULAR NO.25, BANDARHARJO, SEMARANG UTARA, SEMARANG, JAWA TENGAH"],
            ["city" => "PT PELNI CAB SURABAYA", "address" => "JL. PAHLAWAN NO.112, KREMBANGAN, SURABAYA, JAWA TIMUR"],
            ["city" => "PT PELNI CAB MAKASSAR", "address" => "JL. JENDERAL SUDIRMAN NO.14, SAWERIGADING, UJUNG PANDANG, MAKASSAR, SULAWESI SELATAN"],
            ["city" => "PT PELNI CAB AMBON", "address" => "JL. D.I. PANJAITAN NO.19, URITETU, SIRIMAU, AMBON, MALUKU"],
            ["city" => "PT PELNI CAB MEDAN", "address" => "JL. GUNUNG KRAKATAU NO.17A, MEDAN, SUMATERA UTARA"],
            ["city" => "PT PELNI CAB BATAM", "address" => "JL. DR. CIPTO MANGUNKUSUMO NO.4 TANJUNG PINGGIR, SEKUPANG, BATAM"],
            ["city" => "PT PELNI CAB TANJUNG PINANG", "address" => "JL. JEND. AHMAD YANI NO. 06 (KM. 5 ATAS) KEL. SEI JENG KEC. BUKIT BESTARI, TANJUNG PINANG, KEPULAUAN RIAU"],
            ["city" => "PT PELNI CAB BALI", "address" => "JL. RAYA KUTA NO. 299, TUBAN, BADUNG, BALI."],
            ["city" => "PT PELNI CAB KUMAI", "address" => "Jl. SUDIRMAN SH No. 16, KEL. SIDOREJO PANGKALAN BUN, KEC. ARUT SELATAN, KAB. KOTAWARINGIN BARAT, KALIMANTAN TENGAH"],
            ["city" => "PT PELNI CAB SAMPIT", "address" => "JL. A. YANI NO. 70, KEL. MENTAWA BARU HULU, KEC. MENTAWA BARU KETAPANG, KAB KOTAWARINGIN TIMUR, KALIMANTAN TENGAH, 74322"],
            ["city" => "PT PELNI CAB BATULICIN", "address" => "PT. PELNI CAB. BATULICIN JALAN RAYA BATULICIN, KAMPUNG BARU, KEC. SIMPANG EMPAT, KAB. TANAH BUMBU, KALIMANTAN SELATAN, 72212"],
            ["city" => "PT PELNI CAB BALIKPAPAN", "address" => "JL. YOS SUDARSO NO.1 KEL. PRAPATAN, KEC. BALIKPAPAN, KOTA BALIKPAPAB, KALIMANTAN TIMUR 76111"],
            ["city" => "PT PELNI CAB TIMIKA", "address" => "JL. KARTINI NO. 5, KEL. INAUGA, DISTRIK MIMIKA BARU, KAB. TIMIKA, PROV. PAPUA TENGAH 99971"],
            ["city" => "PT PELNI CAB TARAKAN", "address" => "JL. KUSUMA BANGSA RT/RW 07/03 NO. 100, KEL. GUNUNG LINGKAS, KEC. TARAKAN TIMUR, KAB. TARAKAN, PROV. KALIMANTAN UTARA 77126"],
            ["city" => "PT PELNI CAB JAYAPURA", "address" => "JL. ARGAPURA NO.15, ARGAPURA, DISTRIK JAYAPURA SELATAN, KOTA JAYAPURA, PAPUA"],
            ["city" => "PT PELNI CAB PAREPARE", "address" => "JL. LASIMING NO.44, UJUNG, PARE-PARE, SULAWESI SELATAN"],
            ["city" => "PT PELNI CAB BAUBAU", "address" => "JL. PAHLAWAN NO.1 BAU-BAU, BUTON, SULAWESI TENGGARA"],
            ["city" => "PT PELNI CAB KENDARI", "address" => "JL. LAKIDENDE KOTA LAMA NO.10, KANDAI, KENDARI, SULAWESI TENGGARA"],
            ["city" => "PT PELNI CAB LARANTUKA", "address" => "JL. DON LORENZO DVG, LOHAYONG, LARANTUKA, FLORES TIMUR, NUSA TENGGARA TIMUR"],
            ["city" => "PT PELNI CAB PALU", "address" => "JL. RA KARTINI NO.96, PALU TIMUR, PALU, SULAWESI TENGAH"],
            ["city" => "PT PELNI CAB MAUMERE", "address" => "JL. DON JUAN NO.6, ALOK, SIKKA, FLORES, NUSA TENGGARA TIMUR"],
            ["city" => "PT PELNI CAB KUPANG", "address" => "JL. PAHLAWAN NO.7, FATUFETO, ALAK, KUPANG, NUSA TENGGARA TIMUR"],
            ["city" => "PT PELNI CAB LABUAN BAJO", "address" => "JL. TRANS FLORES, PASAR BARU, MANGGARAI BARAT, NUSA TENGGARA TIMUR"],
            ["city" => "PT PELNI CAB KAIMANA", "address" => "JL. DIPONEGORO, KAIMANA, PAPUA BARAT"],
            ["city" => "PT PELNI CAB SORONG", "address" => "JL. JEND. A. YANI KOMP. PELABUHAN SORONG - PAPUA BARAT"],
            ["city" => "PT PELNI CAB MANOKWARI", "address" => "JL. SILIWANGI NO. 24, MANOKWARI BARAT, MANOKWARI, PAPUA BARAT"],
            ["city" => "PT PELNI CAB LUWUK", "address" => "JL. SUNGAI LIMBOTO NO. 74, BUNGIN, LUWUK, BANGGAI, SULAWESI TENGAH"],
            ["city" => "PT PELNI CAB BITUNG", "address" => "JL. SAM RATULANGI NO. 7, BITUNG, SULAWESI UTARA"],
            ["city" => "PT PELNI CAB PONTIANAK", "address" => "JL. SULTAN ABDURAHMAN NO.12, SUNGAI BANGKONG, PONTIANAK, KALIMANTAN BARAT"],
            ["city" => "PT PELNI CAB BIMA", "address" => "JL. KESATRIA NO.2, PENATOI, MPUNDA, BIMA, NUSA TENGGARA BARAT"],
            ["city" => "PT PELNI CAB TERNATE", "address" => "JL. JEND. A. YANI KOMP. PELABUHAN TERNATE, MALUKU UTARA"],
            ["city" => "PT PELNI CAB MERAUKE", "address" => "JL. SABANG NO. 318, MERAUKE, PAPUA SELATAN"],
            ["city" => "PT PELNI CAB WAINGAPU", "address" => "JL. HASANUDIN NO.1 WAINGAPU SUMBA TIMUR, NUSA TENGGARA TIMUR"],
            ["city" => "PT PELNI CAB ENDE", "address" => "JL. KATEDRAL NO.2, MBONGAWANI, ENDE SELATAN, NUSA TENGGARA TIMUR"],
            ["city" => "PT PELNI CAB NABIRE", "address" => "JL. FRANS KAISEPO NO. 14, NABIRE, PAPUA"],
            ["city" => "PT PELNI CAB NUNUKAN", "address" => "JL. AHMAD YANI NO. 15, NUNUKAN, KALIMANTAN UTARA"],
            ["city" => "PT PELNI CAB FAKFAK", "address" => "JL. D.I. PANJAITAN FAK FAK, PAPUA BARAT"],
            ["city" => "PT PELNI CAB SERUI", "address" => "JL. DR. WAHIDIN SUDIROHUSODO, KEP. YAPEN, SERUI, PAPUA"],
            ["city" => "PT PELNI CAB DOBO", "address" => "JL. YOS SUDARSO NO.22, GALAI DUBU, KEP. ARU, DOBO, MALUKU"],
            ["city" => "PT PELNI CAB TUAL", "address" => "JL. AHMAD YANI NO.2, LODAR EL, TUAL, MALUKU"],
            ["city" => "PT PELNI CAB NAMLEA", "address" => "JL. BTN TATANGGO, NAMLEA, BURU, MALUKU"],
            ["city" => "PT PELNI CAB BIAK", "address" => "JL. JEND. SUDIRMAN NO. 37, BUROKUB, BIAK KOTA, BIAK NUMFOR, PAPUA"],
        ];
        foreach ($branches as $branch) { Branch::create($branch); }
    }
}