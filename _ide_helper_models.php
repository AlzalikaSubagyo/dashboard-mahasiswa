<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $mahasiswa_id
 * @property string $aktivitas
 * @property \Illuminate\Support\Carbon $waktu
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mahasiswa $mahasiswa
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aktivitas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aktivitas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aktivitas query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aktivitas whereAktivitas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aktivitas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aktivitas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aktivitas whereMahasiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aktivitas whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Aktivitas whereWaktu($value)
 */
	class Aktivitas extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $mahasiswa_id
 * @property \Illuminate\Support\Carbon $tanggal
 * @property string $status
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mahasiswa $mahasiswa
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kehadiran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kehadiran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kehadiran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kehadiran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kehadiran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kehadiran whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kehadiran whereMahasiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kehadiran whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kehadiran whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kehadiran whereUpdatedAt($value)
 */
	class Kehadiran extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string $nama
 * @property string $nim
 * @property string $jurusan
 * @property int $semester
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Aktivitas> $aktivitas
 * @property-read int|null $aktivitas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Kehadiran> $kehadirans
 * @property-read int|null $kehadirans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Nilai> $nilais
 * @property-read int|null $nilais_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PklLapora> $pklLapora
 * @property-read int|null $pkl_lapora_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereJurusan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereNim($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mahasiswa whereUserId($value)
 */
	class Mahasiswa extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $semester
 * @property string $nama_matkul
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Nilai> $nilais
 * @property-read int|null $nilais_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataKuliah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataKuliah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataKuliah query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataKuliah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataKuliah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataKuliah whereNamaMatkul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataKuliah whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MataKuliah whereUpdatedAt($value)
 */
	class MataKuliah extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $mahasiswa_id
 * @property int $mata_kuliah_id
 * @property int $minggu
 * @property numeric $nilai
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mahasiswa $mahasiswa
 * @property-read \App\Models\MataKuliah $mataKuliah
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nilai newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nilai newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nilai query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nilai whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nilai whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nilai whereMahasiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nilai whereMataKuliahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nilai whereMinggu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nilai whereNilai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Nilai whereUpdatedAt($value)
 */
	class Nilai extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $mahasiswa_id
 * @property \Illuminate\Support\Carbon $tanggal
 * @property string $kegiatan
 * @property string $status_validasi
 * @property string|null $catatan_pembimbing
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mahasiswa $mahasiswa
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PklLapora newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PklLapora newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PklLapora query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PklLapora whereCatatanPembimbing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PklLapora whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PklLapora whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PklLapora whereKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PklLapora whereMahasiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PklLapora whereStatusValidasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PklLapora whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PklLapora whereUpdatedAt($value)
 */
	class PklLapora extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mahasiswa|null $mahasiswa
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

