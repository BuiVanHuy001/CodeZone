<ul class="social-icon social-default icon-naked justify-content-start">
    @foreach($socials as $platform => $link)
        <li>
            <a href="https://www.{{ $platform }}.com/{{ $link }}" target="_blank">
                <i class="feather-{{ $platform === 'website' ? 'globe' : $platform }}"></i>
            </a>
        </li>
    @endforeach
</ul>
