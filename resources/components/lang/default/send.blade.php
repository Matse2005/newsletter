@props(['text', 'email'])

<p style="color: #3b3b3b; font-size: 12px;">{{ $text }} <a href="mailto:{{ $email }}"
        class="color: black !important">{{ $email }}</a>
</p>
