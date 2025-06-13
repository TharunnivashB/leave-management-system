<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                {{ $header ?? '' }}

                <!-- Email Body -->
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0">
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                            <!-- Body content -->
                            <tr>
                                <td class="content-cell">
                                    {{ $slot ?? '' }}
                                    {{ $subcopy ?? '' }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{ $footer ?? '' }}
            </table>
        </td>
    </tr>
</table>

</td>
</tr>
</table>

<style>
    .wrapper {
        background-color: #f0f4f8;
        padding: 20px;
    }

    .content {
        background-color: #ffffff;
        border: 1px solid #e1e1e1;
        border-radius: 8px;
        font-family: 'Segoe UI', sans-serif;
    }

    .body {
        color: #333333;
    }

    h1,
    h2,
    h3 {
        color: #198754;
    }

    a {
        color: #198754;
        text-decoration: none;
        font-weight: bold;
    }

    .button {
        background-color: #198754 !important;
        color: #ffffff !important;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 6px;
    }

    .content-cell {
        padding: 32px;
    }
</style>