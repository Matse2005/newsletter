@php
    $color = app(App\Settings\EmailSetting::class)->primary;
@endphp

<!DOCTYPE html>
<html>

<head>
    <title>{{ $newsletter->title }}</title>

    <style>
        a {
            color: rgb(from {{ $color }} r g b) !important;
        }

        a:hover {
            color: rgb(from {{ $color }} r g b / 70%);
        }

        .button {
            color: white !important;
            padding: 8px 20px 8px 20px;
            background-color: rgb(0, 0, 0);
            font-size: 16px;
            text-align: center;
            display: inline-block;
            word-wrap: break-word;
            transition: all;
            border-radius: 6px;
            text-decoration: none;
        }

        .button:hover {
            background-color: rgb(0, 0, 0, 0.7);
            color: white !important;
        }

        .button-primary {
            color: white !important;
            background-color: rgb(from {{ $color }} r g b);
        }

        .button-primary:hover {
            color: white !important;
            background-color: rgba(from {{ $color }} r g b / 70%);
        }

        hr {
            background-color: gray;
            height: 1px;
            border: 0;
        }
    </style>
</head>

<body style="" class="">
    <div style="max-width: 40rem; margin-left: auto; margin-right: auto; padding: 1.5rem; width: 100%;">
        <img src="{{ config('app.url') }}/storage/{{ app(App\Settings\EmailSetting::class)->logo }}"
            alt="Dezittere Philac | Logo" style="width: 17rem; display: block; margin-left: auto; margin-right: auto;">
        <div class="tiptap-wrapper" style="background-color: white; border-radius: 1rem; padding: 1.2rem 2rem">
            <div class="tiptap-prosemirror-wrapper">
                {!! format_email($newsletter->email) !!}
            </div>
        </div>
        <div class="" style="text-align: center;">
            @isset($email)
                <div style="margin-bottom: -8px;"> <!-- Adjust the bottom margin -->
                    <p style="color: #3b3b3b; font-size: 12px;">
                        {{ json_decode($newsletter->language->translations)->email->footer->send_to }} <a
                            href="mailto:{{ $email }}">{{ $email }}</a>
                    </p>
                </div>
            @endisset
            <div style="margin-bottom: -8px;"> <!-- Adjust the top margin -->
                <p style="color: #3b3b3b; font-size: 12px;">
                    {{ json_decode($newsletter->language->translations)->email->footer->company }}</p>
            </div>
            @isset($email)
                <div style="margin-bottom: -8px;"> <!-- Adjust the top margin -->
                    <p style="color: #3b3b3b; font-size: 12px;">
                        {{ json_decode($newsletter->language->translations)->email->footer->in_browser }}, <a
                            href="{{ config('app.url') }}/newsletter/{{ $newsletter->id }}">{{ json_decode($newsletter->language->translations)->email->footer->click_here }}</a>
                    </p>
                </div>
            @endisset
            <div style=""> <!-- Adjust the top margin -->
                <p style="font-size: 12px;">
                    @isset($email)
                        @if ($newsletter->group->can_unsubscribe)
                            <a href="{{ config('app.url') }}/unsubscribe?email={{ $email }}&lang={{ $newsletter->language->key }}"
                                target="_blank"
                                rel="noopener noreferrer">{{ json_decode($newsletter->language->translations)->email->footer->unsubscribe }}</a>
                            <span style="color:#c4c4c4;font-size:12px">|</span>
                        @endif
                    @endisset
                    <a href="{{ json_decode($newsletter->language->translations)->email->footer->urls->privacy_statement }}"
                        target="_blank"
                        rel="noopener noreferrer">{{ json_decode($newsletter->language->translations)->email->footer->privacy_statement }}</a>
                    <span style="color:#c4c4c4;font-size:12px">|</span>
                    <a href="{{ json_decode($newsletter->language->translations)->email->footer->urls->tos }}"
                        target="_blank"
                        rel="noopener noreferrer">{{ json_decode($newsletter->language->translations)->email->footer->tos }}</a>
                </p>

            </div>
        </div>
    </div>
</body>

</html>
