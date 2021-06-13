package com.example.splashapp.Dialogs;

import android.app.DialogFragment;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.CheckBox;
import android.widget.Spinner;

import com.example.splashapp.C_Organization;
import com.example.splashapp.ListOfOrg;
import com.example.splashapp.MyOrgProf;
import com.example.splashapp.R;

public class SpinnerDialog extends DialogFragment {

    public void onClick(View view) {
        currenttype=spinner.getSelectedItem().toString();
        if (mycity)
            ListOfOrg.forsCity= C_Organization.MyOrg.getCity();
        else ListOfOrg.forsCity="";
        if (currenttype=="Любое")
            ListOfOrg.forsCity="";
        else ListOfOrg.forsAct=currenttype;
        dismiss();
}
    protected String[] typeof={"all", "child","homeless","animals"};
    protected Spinner spinner;
    protected String currenttype;
    protected boolean mycity=false;

    public String getCurrentType(){
        return currenttype;
    }
    public boolean getMyCity(){
        return mycity;
    }
    public void setMyCity(boolean mycity){
        this.mycity=mycity;
    }

    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.typeact_dialog, null);
        getDialog().getWindow().setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));
        mycity=false;
        spinner = (Spinner) v.findViewById(R.id.typeofactivity);
        spinner.setPrompt("Вид деятельности");
        if(typeof!=null)
        {
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_spinner_item, typeof);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinner.setAdapter(adapter);
        }

        v.findViewById(R.id.ok).setOnClickListener(this::onClick);

        CheckBox checkboxvariable=(CheckBox)v.findViewById(R.id.mycity);

        checkboxvariable.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                C_Organization.filter = spinner.getSelectedItem().toString();

                if (((CheckBox) v).isChecked()) {
                    mycity = true;
                } else {
                    mycity = false;
                }
            }
        });

        return v;
    }

}


