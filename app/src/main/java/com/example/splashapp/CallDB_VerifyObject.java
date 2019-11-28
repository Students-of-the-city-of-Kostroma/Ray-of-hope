package com.example.splashapp;

import android.annotation.TargetApi;
import android.net.Uri;
import android.os.AsyncTask;

import android.os.Build;
import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.URL;


import javax.net.ssl.HttpsURLConnection;


@TargetApi(Build.VERSION_CODES.CUPCAKE)
public class CallDB_VerifyObject extends AsyncTask<String , Void ,String>
{
    public CallDB_VerifyObject(){}

    @Override
    protected void onPreExecute() {
        super.onPreExecute();
    }

    @Override
    protected void onPostExecute(String result) {
        super.onPostExecute(result);
    }

    @TargetApi(Build.VERSION_CODES.O)
    @Override
    public String doInBackground(String... params) {
        String response = "";
        OutputStream out = null;

        try {
            URL url = new URL("http://rayofhope-opensource.hostingerapp.com/functions/functions.php");
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            conn.setReadTimeout(10000);
            conn.setConnectTimeout(15000);
            conn.setRequestMethod("POST");
            conn.setDoInput(true);
            conn.setDoOutput(true);
            Uri.Builder builder = new Uri.Builder()
                    .appendQueryParameter("post_id", params[1])
                    .appendQueryParameter("post_name", params[2])
                    .appendQueryParameter("post_description", params[3])
                    .appendQueryParameter("post_postDate", params[4]);
            if (params[0].equals("M_Need")) {
                builder.appendQueryParameter("post_whatNeed", params[5])
                        .appendQueryParameter("post_percent", params[6]);
            } else if (params[0].equals("M_Activism"))
            {
                builder.appendQueryParameter("post_date", params[5]);
            }
            String query = builder.build().getEncodedQuery();
            OutputStream os = conn.getOutputStream();
            BufferedWriter writer = new BufferedWriter(
                    new OutputStreamWriter(os, "UTF-8"));
            writer.write(query);
            writer.flush();
            writer.close();
            os.close();
            int responseCode = conn.getResponseCode();
            if (responseCode == HttpsURLConnection.HTTP_OK) {
                String line;
                BufferedReader br = new BufferedReader(new InputStreamReader(conn.getInputStream()));
                while ((line = br.readLine()) != null) { response += line; }
            } else { response = "error"; }
        } catch (Exception e) { System.out.println(e.getMessage());
        }
        return response;
    }
}
