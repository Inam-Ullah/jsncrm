<footer>
    <div class="pull-left">
        {{ setting()->name ?? 'JSN ISP CRM' }}
        @if(setting()->slogan)
            | {{ setting()->slogan }}
        @endif
    </div>
    <div class="pull-right">
        @if(setting()->copyright)
            {{ setting()->copyright }}
        @endif
        @if(setting()->jsntext == 1)
            | ISP CRM by JSN
        @endif
    </div>
    <div class="clearfix"></div>
</footer>
