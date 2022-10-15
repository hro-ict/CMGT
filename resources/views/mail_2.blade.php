
<style>
    table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

thead {
    font-weight: bold;
}

td, th {
  border: 3px solid #dddddd;
  text-align: left;
  padding: 8px;
  
}

/*tr{*/
/*  background-color: #dddddd;*/
/*}*/
</style>

<p style="font-weight:bold">Dear {{$name}},</p>
<h4>Status your article:</h4>

<table>
    <thead>
        <tr>
            <td>
                Title
            </td>
             <td>
                Status
            </td>
        </tr>
    </thead>
    <tr>
        <td>
           {{$title}} 
        </td>
        <td>
           {{$status}} 
        </td>
    </tr>
</table>

<p>Sent from Mail My Articles</p>
