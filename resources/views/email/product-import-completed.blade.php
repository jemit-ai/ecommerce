<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product Import Completed</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background:#f4f4f4; padding:20px;">

<table width="600" align="center" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:8px;padding:30px;">
    <tr>
        <td>

            <h2 style="color:#16a34a;">
                ✅ Product Import Completed
            </h2>

            <p>Hello,</p>

            <p>
                Your product import has completed successfully.
            </p>

            <table cellpadding="8" cellspacing="0" width="100%" style="border-collapse:collapse; margin-top:20px;">
                <tr style="background:#f8fafc;">
                    <td><strong>Import ID</strong></td>
                    <td>{{ $import->id }}</td>
                </tr>

                <tr>
                    <td><strong>Status</strong></td>
                    <td>{{ ucfirst($import->status) }}</td>
                </tr>

                <tr style="background:#f8fafc;">
                    <td><strong>Total Rows</strong></td>
                    <td>{{ $import->total_rows }}</td>
                </tr>

                <tr>
                    <td><strong>Processed Rows</strong></td>
                    <td>{{ $import->processed_rows }}</td>
                </tr>

                <tr style="background:#f8fafc;">
                    <td><strong>Failed Rows</strong></td>
                    <td>{{ $import->failed_rows }}</td>
                </tr>

                <tr>
                    <td><strong>Completed At</strong></td>
                    <td>{{ now()->format('d M Y h:i A') }}</td>
                </tr>

            </table>

            <p style="margin-top:30px;">
                The original import file has been attached with this email.
            </p>

            <p>
                Thank you,<br>
                <strong>{{ config('app.name') }}</strong>
            </p>

        </td>
    </tr>
</table>

</body>
</html>