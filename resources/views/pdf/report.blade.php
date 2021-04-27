<html>
   <head>
        <title>Tiny twitter report</title>
        <style>
            table, td, th {
                border: 1px solid black;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }
            td {
               text-align: center;
            }
        </style>
   </head>
   <body>
        <h2>Users Table </h2>
        <p>This table shows all users in the system and count of tweets for each one:</p>
        <table>
            <tr>
                <th>User name</th>
                <th>User email</th>
                <th>Date of birth</th>
                <th>Tweets count</th>
            </tr>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->date_of_birth }}</td>
                <td>{{ $user->tweets_count }}</td>
            </tr>
            @endforeach
        </table>
   </body>
</html>