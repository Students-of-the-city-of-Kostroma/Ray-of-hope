package com.example.splashapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

public class Another extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_another);

        TextView textview= (TextView) findViewById(R.id.textView17);
        textview.setText(MyOrgProf.MyOrg.getName());
    }
    public  void ToMyProf(View view)
    {
        boolean cit=Choice.citezen;
        if (cit) {
            Intent intent = new Intent(this, CitProf.class);
            startActivity(intent);
        }
        else { Intent intent = new Intent(this, MyOrgProf.class);
            startActivity(intent);}

        finish();
    }

    public  void ToComm(View view)
    {

    }
    public  void ToMark(View view)
    {

    }
    public  void ToSetting(View view)
    {

    }
    public  void ToFAQ(View view)
    {
        Intent intent = new Intent(this, Q_A.class);
        startActivity(intent);
        finish();
    }
    public  void ToAbout(View view)
    {
        Intent intent = new Intent(this, AboutView.class);
        startActivity(intent);
    }


}
