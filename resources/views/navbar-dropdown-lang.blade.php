<li class="nav-item dropdown">
    <a id="navbarDropdownLang" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        {{ config('languages')[app()->getLocale()]['display-short'] }}
    </a>

    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownLang">
    @foreach (config('languages') as $lang => $language)
        @if ($lang != app()->getLocale())
            <a class="dropdown-item" href="{{ route('change-lang') }}?lang={{ $lang }}">
                </span>&nbsp;{{$language['display']}}
            </a>
        @endif
    @endforeach
    </div>
</li>
