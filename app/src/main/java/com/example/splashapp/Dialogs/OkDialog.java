package com.example.splashapp.Dialogs;

import android.annotation.SuppressLint;
import android.app.DialogFragment;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Build;
import android.os.Bundle;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.example.splashapp.R;

public class OkDialog extends DialogFragment  {

    public void onClick(View view) {
        dismiss();
    }
    protected String head;
    protected String mess;

    public void setHead(String header){
        this.head = header;
    }

    public void setMess(String message){
        this.mess = message;
    }

    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.ok_dialog, null);
        getDialog().getWindow().setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));

        if(mess!=null)
            ((TextView)v.findViewById(R.id.mess)).setText(mess);

        if(head!=null)
            ((TextView)v.findViewById(R.id.head)).setText(head);

        v.findViewById(R.id.ok).setOnClickListener(this::onClick);
        return v;
    }
}
