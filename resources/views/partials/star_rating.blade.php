{{--
    Partial: Rating Bintang (5 level)
    Wajib pass variabel $q (objek SurveyQuestion)
--}}
@php
    $labelBintang = [
        1 => 'Mengecewakan',
        2 => 'Kurang',
        3 => 'Netral',
        4 => 'Baik',
        5 => 'Memuaskan',
    ];
@endphp

<div class="star-rating-wrap" data-question="{{ $q->id }}">
    <div class="star-rating-row">
        @foreach ($labelBintang as $val => $label)
            <label class="star-rating-item">
                <input type="radio" name="jawaban[{{ $q->id }}]" value="{{ $val }}" {{ $q->wajib_diisi ? 'required' : '' }}
                       onchange="updateStarRating(this)">
                <i class="bi bi-star star-icon" data-value="{{ $val }}"></i>
                <span class="star-label">{{ $label }}</span>
            </label>
        @endforeach
    </div>
</div>

<script>
    // Mengisi bintang (fill) sesuai nilai yang dipilih pada baris rating terkait
    function updateStarRating(radioInput) {
        const row = radioInput.closest('.star-rating-row');
        const selectedValue = parseInt(radioInput.value, 10);
        row.querySelectorAll('.star-icon').forEach(function (icon) {
            const val = parseInt(icon.dataset.value, 10);
            icon.classList.toggle('filled', val <= selectedValue);
            icon.classList.toggle('bi-star', val > selectedValue);
            icon.classList.toggle('bi-star-fill', val <= selectedValue);
        });
    }
</script>
