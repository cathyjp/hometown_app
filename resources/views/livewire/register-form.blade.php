<?php

use function Livewire\Volt\{state, title};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Data\PrefectureData;
use App\Models\Reasons;

title('ふるさと住民登録申請フォーム｜平泉町');

// reasonsテーブルからデータを取得
$reasons = Reasons::all();

// 確認画面から戻ってきた場合はセッションデータを取得
$formData = [];
$editMode = session('form_edit_mode', false);

if ($editMode) {
    $formData = session('hometown_register', []);
    // 編集モードフラグをクリア
    session(['form_edit_mode' => false]);
} else {
    // セッションデータがある場合（testからの遷移など）も読み込む
    $sessionData = session('hometown_register', []);
    if (!empty($sessionData) && isset($sessionData['last_name']) && isset($sessionData['first_name'])) {
        $formData = $sessionData;
    }
}

// reasonの値を取得
$reasonValue = $formData['reason'] ?? '';
$reasonValue = $reasonValue ? (string) $reasonValue : '';

state([
    'last_name' => $formData['last_name'] ?? '',
    'first_name' => $formData['first_name'] ?? '',
    'last_name_kana' => $formData['last_name_kana'] ?? '',
    'first_name_kana' => $formData['first_name_kana'] ?? '',
    'postal_code' => $formData['postal_code'] ?? '',
    'prefecture' => $formData['prefecture'] ?? '',
    'city' => $formData['city'] ?? '',
    'address' => $formData['address'] ?? '',
    'phone' => $formData['phone'] ?? '',
    'gender' => $formData['gender'] ?? '',
    'birth_year' => $formData['birth_year'] ?? '',
    'birth_month' => $formData['birth_month'] ?? '1',
    'reason' => $reasonValue, // 申請理由
    'privacy_policy' => false, // プライバシーポリシーは常に未チェック状態から
    'errors' => [],
    'reasons' => $reasons, // reasonsリスト
]);

$submit = function () {
    $validator = Validator::make(
        [
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'last_name_kana' => $this->last_name_kana,
            'first_name_kana' => $this->first_name_kana,
            'postal_code' => $this->postal_code,
            'prefecture' => $this->prefecture,
            'city' => $this->city,
            'address' => $this->address,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'birth_year' => $this->birth_year,
            'birth_month' => $this->birth_month,
            'reason' => $this->reason,
            'privacy_policy' => $this->privacy_policy,
        ],
        [
            'last_name' => 'required',
            'first_name' => 'required',
            'last_name_kana' => 'required|regex:/^[ぁ-んー]+$/u',
            'first_name_kana' => 'required|regex:/^[ぁ-んー]+$/u',
            'postal_code' => 'required|regex:/^\d{7}$/',
            'prefecture' => 'required',
            'city' => 'required',
            'phone' => 'required|regex:/^\d{10,11}$/',
            'gender' => 'required',
            'birth_year' => 'required|integer|min:1900|max:' . date('Y'),
            'birth_month' => 'required|integer|min:1|max:12',
            'reason' => 'required',
            'privacy_policy' => 'accepted',
        ],
        [
            'last_name.required' => '姓を入力してください',
            'first_name.required' => '名を入力してください',
            'last_name_kana.required' => '姓（ふりがな）を入力してください',
            'last_name_kana.regex' => 'ひらがなで入力してください',
            'first_name_kana.required' => '名（ふりがな）を入力してください',
            'first_name_kana.regex' => 'ひらがなで入力してください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '郵便番号は7桁の数字で入力してください',
            'prefecture.required' => '都道府県を選択してください',
            'city.required' => '市区町村・番地を入力してください',
            'phone.required' => '電話番号を入力してください',
            'phone.regex' => '電話番号は10桁または11桁の数字で入力してください',
            'gender.required' => '性別を選択してください',
            'birth_year.required' => '生年を入力してください',
            'birth_year.integer' => '生年は数字で入力してください',
            'birth_year.min' => '生年は1900年以降で入力してください',
            'birth_year.max' => '生年は' . date('Y') . '年以前で入力してください',
            'birth_month.required' => '生月を選択してください',
            'birth_month.integer' => '生月は数字で入力してください',
            'birth_month.min' => '生月は1〜12の間で選択してください',
            'birth_month.max' => '生月は1〜12の間で選択してください',
            'reason.required' => '申請理由を選択してください',
            'privacy_policy.accepted' => '個人情報の取扱いについて同意してください',
        ],
    );

    if ($validator->fails()) {
        $this->errors = $validator->errors()->toArray();
        return;
    }

    // フォームデータをセッションに保存
    session([
        'hometown_register' => [
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'last_name_kana' => $this->last_name_kana,
            'first_name_kana' => $this->first_name_kana,
            'postal_code' => $this->postal_code,
            'prefecture' => $this->prefecture,
            'city' => $this->city,
            'address' => $this->address,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'birth_year' => $this->birth_year,
            'birth_month' => $this->birth_month,
            'reason' => $this->reason,
        ],
    ]);

    // 確認画面へリダイレクト
    return redirect()->route('hometown.register.confirm');
};

// 郵便番号から住所を取得する関数
$fetchAddress = function () {
    if (strlen($this->postal_code) === 7) {
        // 7桁の数字
        // 実際の実装ではAPIを使用して住所を取得
        // ここではサンプルとして固定値を設定
        if ($this->postal_code === '0294192') {
            $this->prefecture = '岩手県';
            $this->city = '西磐井郡平泉町平泉字志羅山45-2';
        }
    }
};

?>

<div>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register-form.css') }}">

    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('hometown.about') }}">ふるさと住民制度</a> &gt;
            <span>登録情報入力</span>
        </div>

        <div class="content-box">
            <h1 class="page-title">ふるさと住民登録申請フォーム</h1>

            <div class="form-description">
                <p>以下の情報を入力してください。</p>
            </div>

            <form wire:submit.prevent="submit" class="registration-form">
                <div class="form-section">
                    <div class="form-row three-column name-row">
                        <div class="form-label-column">
                            <label for="last_name" class="form-label required">お名前</label>
                        </div>
                        <div class="form-input-column">
                            <div class="name-container">
                                <div class="name-field">
                                    <div class="input-with-label">
                                        <div class="name-label">姓</div>
                                        <input type="text" id="last_name" wire:model="last_name" class="form-input"
                                            placeholder="例）平泉">
                                    </div>
                                    @if (isset($errors['last_name']))
                                        <span class="error-message">{{ $errors['last_name'][0] }}</span>
                                    @endif
                                </div>
                                <div class="name-field">
                                    <div class="input-with-label">
                                        <div class="name-label">名</div>
                                        <input type="text" id="first_name" wire:model="first_name" class="form-input"
                                            placeholder="例）太郎">
                                    </div>
                                    @if (isset($errors['first_name']))
                                        <span class="error-message">{{ $errors['first_name'][0] }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row three-column name-row">
                        <div class="form-label-column">
                            <label for="last_name_kana" class="form-label required">ふりがな</label>
                        </div>
                        <div class="form-input-column">
                            <div class="name-container">
                                <div class="name-field">
                                    <div class="input-with-label">
                                        <div class="name-label">せい</div>
                                        <input type="text" id="last_name_kana" wire:model="last_name_kana"
                                            class="form-input" placeholder="例）ひらいずみ">
                                    </div>
                                    @if (isset($errors['last_name_kana']))
                                        <span class="error-message">{{ $errors['last_name_kana'][0] }}</span>
                                    @endif
                                </div>
                                <div class="name-field">
                                    <div class="input-with-label">
                                        <div class="name-label">めい</div>
                                        <input type="text" id="first_name_kana" wire:model="first_name_kana"
                                            class="form-input" placeholder="例）たろう">
                                    </div>
                                    @if (isset($errors['first_name_kana']))
                                        <span class="error-message">{{ $errors['first_name_kana'][0] }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row three-column">
                        <div class="form-label-column">
                            <label for="postal_code" class="form-label required">郵便番号</label>
                        </div>
                        <div class="form-input-column">
                            <div class="name-container">
                                <div class="name-field">
                                    <input type="text" id="postal_code" wire:model.lazy="postal_code"
                                        wire:change="fetchAddress" class="form-input" placeholder="例：1234567">
                                    <span class="form-hint">※ハイフンなしで7桁の数字を入力してください</span>
                                    @if (isset($errors['postal_code']))
                                        <span class="error-message">{{ $errors['postal_code'][0] }}</span>
                                    @endif
                                </div>
                                <div class="name-field" style="visibility: hidden;">
                                    <!-- 空のフィールド（姓名の構造に合わせるため） -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row three-column">
                        <div class="form-label-column">
                            <label for="prefecture" class="form-label required">都道府県</label>
                        </div>
                        <div class="form-input-column">
                            <select id="prefecture" wire:model="prefecture" class="form-select">
                                <option value="">選択してください</option>
                                @foreach (PrefectureData::getPrefectures() as $pref)
                                    <option value="{{ $pref }}">{{ $pref }}</option>
                                @endforeach
                            </select>
                            @if (isset($errors['prefecture']))
                                <span class="error-message">{{ $errors['prefecture'][0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-row three-column">
                        <div class="form-label-column">
                            <label for="city" class="form-label required">市区町村・番地</label>
                        </div>
                        <div class="form-input-column">
                            <input type="text" id="city" wire:model="city" class="form-input"
                                placeholder="例：西磐井郡平泉町平泉字志羅山45-2">
                            @if (isset($errors['city']))
                                <span class="error-message">{{ $errors['city'][0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-row three-column">
                        <div class="form-label-column">
                            <label for="address" class="form-label">建物名・部屋番号など</label>
                        </div>
                        <div class="form-input-column">
                            <input type="text" id="address" wire:model="address" class="form-input"
                                placeholder="例：平泉マンション101号室">
                        </div>
                    </div>

                    <div class="form-row three-column">
                        <div class="form-label-column">
                            <label for="phone" class="form-label required">電話番号</label>
                        </div>
                        <div class="form-input-column">
                            <input type="tel" id="phone" wire:model="phone" class="form-input"
                                placeholder="例：09012345678">
                            <span class="form-hint">※ハイフンなしで入力してください</span>
                            @if (isset($errors['phone']))
                                <span class="error-message">{{ $errors['phone'][0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-row three-column">
                        <div class="form-label-column">
                            <label for="gender" class="form-label required">性別</label>
                        </div>
                        <div class="form-input-column">
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" name="gender" wire:model="gender" value="男性">
                                    <span>男性</span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="gender" wire:model="gender" value="女性">
                                    <span>女性</span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" name="gender" wire:model="gender" value="選択しない">
                                    <span>選択しない</span>
                                </label>
                            </div>
                            @if (isset($errors['gender']))
                                <span class="error-message">{{ $errors['gender'][0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-row three-column">
                        <div class="form-label-column">
                            <label for="birth_year" class="form-label required">生年月日(年・月)</label>
                        </div>
                        <div class="form-input-column">
                            <div class="date-inputs-wrapper">
                                <div class="date-field">
                                    <div class="input-with-label">
                                        <input type="number" id="birth_year" wire:model="birth_year"
                                            class="form-input date-input birth-year-input" min="1910"
                                            max="{{ date('Y') }}" placeholder="例：1990">
                                        <div class="date-label">年</div>
                                    </div>
                                    @if (isset($errors['birth_year']))
                                        <span class="error-message">{{ $errors['birth_year'][0] }}</span>
                                    @endif
                                </div>
                                <div class="date-field">
                                    <div class="input-with-label">
                                        <select id="birth_month" wire:model="birth_month"
                                            class="form-select birth-month-select">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <div class="date-label">月</div>
                                    </div>
                                    @if (isset($errors['birth_month']))
                                        <span class="error-message">{{ $errors['birth_month'][0] }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 申請理由 -->
                    <div class="form-row three-column reason-row">
                        <div class="form-label-column">
                            <label class="form-label required">申請理由</label>
                        </div>
                        <div class="form-input-column">
                            <ul class="eligibility-list">
                                @foreach ($reasons as $reasonItem)
                                    <li>
                                        <label>
                                            <input type="radio" wire:model="reason" value="{{ $reasonItem->id }}"
                                                id="reason_{{ $reasonItem->id }}"
                                                @if (!empty($reason) && (string) $reason === (string) $reasonItem->id) checked @endif>
                                            {{ $reasonItem->description }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                            @if (isset($errors['reason']))
                                <span class="error-message">{{ $errors['reason'][0] }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- 個人情報の取り扱い -->
                <div class="form-section privacy-policy">
                    <div class="privacy-policy-content">
                        <p>平泉町では、ふるさと住民登録に関する個人情報を以下のように取り扱います。</p>
                        <ol>
                            <li>取得した個人情報は、ふるさと住民制度の運営・管理のためにのみ利用します。</li>
                            <li>法令に基づく場合を除き、本人の同意なく第三者に提供することはありません。</li>
                            <li>個人情報の取り扱いを委託する場合は、委託先に対して適切な管理・監督を行います。</li>
                            <li>本人から個人情報の開示・訂正・削除の申し出があった場合は、速やかに対応します。</li>
                        </ol>
                    </div>
                    <div class="form-input-column checkbox-center">
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" wire:model.live="privacy_policy">
                                <span>個人情報の取扱いについて同意する</span>
                            </label>
                            @if (isset($errors['privacy_policy']))
                                <span class="error-message">{{ $errors['privacy_policy'][0] }}</span>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="btn-container">
                    <button type="submit" class="btn btn-large"
                        @if (!$privacy_policy) disabled @endif>申請内容の確認へ</button>
                </div>
            </form>
        </div>
    </div>
</div>
